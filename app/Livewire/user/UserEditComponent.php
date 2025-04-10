<?php

namespace App\Livewire\user;

use App\Services\Post\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserEditComponent extends Component
{
    public $username;
    public $userData = [];
    public $form = [];
    
    public function mount(UserService $userService, $username)
    {
        $this->userService = $userService;
        $this->username = $username;
        
        // Check if user is authorized to edit this profile
        if (!Auth::check() || (Auth::user()->username != $username && Auth::user()->role != ROLE_ADMIN)) {
            abort(403, 'Unauthorized action.');
        }
        
        $res = $this->userService->getOneWithAttrs($username);
        if (!$res) {
            abort(404);
        }
        
        $this->userData = $res;
        
        // Initialize form data from user data
        if (isset($res['user'])) {
            $this->form = [
                'name' => $res['user']->name,
                'email' => $res['user']->email,
                'phone' => $res['user']->phone,
                'address' => $res['user']->address,
            ];
        }
    }
    
    public function render()
    {
        return view('livewire.user.edit', [
            'userData' => $this->userData,
            'username' => $this->username
        ]);
    }
    
    public function update()
    {
        // Validate the form data
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.address' => 'nullable|string|max:500',
        ]);
        
        // Create a request-like array to pass to the service
        $requestData = [
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'phone' => $this->form['phone'],
            'address' => $this->form['address'],
        ];
        
        // Call the service method
        $data = $this->userService->update((object) ['all' => function() use ($requestData) { return $requestData; }], $this->username);
        
        // Flash message and dispatch event
        session()->flash('message', 'User updated successfully');
        $this->dispatch('userUpdated', $data);
        
        // Redirect to profile page
        return redirect()->route('user.show', $this->username);
    }
} 