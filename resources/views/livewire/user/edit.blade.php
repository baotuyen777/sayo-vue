@section('title', 'Edit User')

<div>
    <div class="container">
        <h1>Edit User</h1>
        
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        
        <form wire:submit.prevent="update">
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" wire:model="form.name" id="name" required>
                @error('form.name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" wire:model="form.email" id="email" required>
                @error('form.email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" wire:model="form.phone" id="phone">
                @error('form.phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <textarea class="form-control" wire:model="form.address" id="address" rows="3"></textarea>
                @error('form.address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('user.show', $username) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div> 