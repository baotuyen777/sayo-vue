<?php

namespace App\Livewire\user;

use App\Models\User;
use App\Services\Post\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndexComponent extends Component
{
    use WithPagination;
    
    protected $listeners = ['destroy'];
    
    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role != ROLE_ADMIN) {
            abort(404);
        }
    }

    public function render()
    {
        $objs = User::getAll(request(), true);
        return view('livewire.user.index', ['objs' => $objs]);
    }
    
    public function destroy($userName)
    {
        $res = $this->userService->destroy($userName);
        session()->flash('message', 'User deleted successfully');
        
        $this->dispatch('userDeleted', $res);
    }
} 