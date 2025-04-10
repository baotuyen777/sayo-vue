@section('title', 'User Profile')

<div>
    <div class="container">
        <h1>My Profile</h1>
        
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->phone }}</p>
                        <p>{{ $user->address }}</p>
                        
                        <a href="{{ route('user.edit', $user->username) }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>My Posts</h4>
                    </div>
                    <div class="card-body">
                        @if(isset($posts) && $posts->count() > 0)
                            <div class="row">
                                @foreach($posts as $post)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>{{ $post->title }}</h5>
                                                <p>{{ Str::limit($post->content, 100) }}</p>
                                                <a href="{{ route('postView', ['catCode' => $post->category->code, 'code' => $post->code]) }}" class="btn btn-sm btn-primary">View</a>
                                                <a href="{{ route('postEdit', ['code' => $post->code]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No posts available.</p>
                        @endif
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>My Products</h4>
                    </div>
                    <div class="card-body">
                        @if(isset($products) && $products->count() > 0)
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>{{ $product->name }}</h5>
                                                <p>{{ $product->price }}</p>
                                                <a href="{{ route('productView', ['catCode' => $product->category->code, 'code' => $product->code]) }}" class="btn btn-sm btn-primary">View</a>
                                                <a href="{{ route('productEdit', ['code' => $product->code]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No products available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 