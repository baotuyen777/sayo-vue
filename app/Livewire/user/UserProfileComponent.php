<?php

namespace App\Livewire\user;

use App\Services\Post\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfileComponent extends Component
{
    public $userData = [];
    
    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        
        $userName = Auth::user()->username;
        $res = $this->userService->getOneWithAttrs($userName);
        
        $this->userData = $res;
    }
    
    public function render()
    {
        return view('livewire.user.profile', $this->userData);
    }
} 