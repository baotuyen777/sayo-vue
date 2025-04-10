@section('title', 'User List')

<div>
    <div class="container">
        <h1>User List</h1>
        
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($objs as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('user.show', $user->username) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('user.edit', $user->username) }}" class="btn btn-sm btn-primary">Edit</a>
                                <button wire:click="$dispatch('confirmDelete', {username: '{{ $user->username }}'})" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $objs->links() }}
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('confirmDelete', (data) => {
                if (confirm('Are you sure you want to delete this user?')) {
                    Livewire.dispatch('destroy', { userName: data.username });
                }
            });
        });
    </script>
</div> 