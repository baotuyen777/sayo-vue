<?php

namespace App\Livewire\user;

use App\Services\Post\UserService;
use Livewire\Component;

class UserComponent extends Component
{
    public $userName;
    
    public function mount(UserService $userService, $userName = null)
    {
        $this->userService = $userService;
        $this->userName = $userName;
    }
    
    public function destroy($userName)
    {
        $res = $this->userService->destroy($userName);
        session()->flash('message', 'User deleted successfully');
        
        $this->dispatch('userDeleted', $res);
        
        return redirect()->route('user.index');
    }
} 