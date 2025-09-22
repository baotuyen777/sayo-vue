<div>
    <div class="card">
        <h2>Bình luận</h2>
        <div class="card__body">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit="store">
                <input type="hidden" wire:model="item_id">
                <div class="comment form-control">
                    <textarea class="required comment__content" 
                              wire:model="content"
                              placeholder="Nhập nội dung bình luận (tiếng Việt có dấu)..."></textarea>
                    @error('content') 
                        <div class="error-message">{{ $message }}</div> 
                    @enderror
                    @error('auth') 
                        <div class="error-message">{{ $message }}</div> 
                    @enderror
                    @error('error') 
                        <div class="error-message">{{ $message }}</div> 
                    @enderror
                </div>
                <div class="btn__comment">
                    <button type="submit" class="btn--primary">
                        GỬI BÌNH LUẬN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div>
        @empty($comments)
            <p>Tin đăng chưa có bình luận, bạn hãy trở thành người bình luận đầu tiên!</p>
        @else
            <div class="panel">
                <div class="panel-body p-10 white-box">
                    @foreach($comments as $comment)
                        <div class="comment-show">
                            <a class="comment__avatar" href="#">
                                <img class="img-circle img-sm"
                                     src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                     alt="Profile Picture">
                            </a>
                            <div class="media-body">
                                <div class="comment__content">
                                    <div>{{ $comment->user->name }} <span class="text-muted text-sm">{{ $comment->remaining_days }}</span></div>
                                    <div>{{ $comment->content }}</div>
                                </div>
                                <div class="comment__action">
                                    <button wire:click="reply({{ $comment->id }})" class="btn--reply">Phản hồi</button>
                                </div>

                                @if($parent_id === $comment->id)
                                    <div class="reply-form">
                                        <form wire:submit="store">
                                            <textarea wire:model="content" placeholder="Trả lời bình luận" rows="4"></textarea>
                                            @error('content') 
                                                <div class="error-message">{{ $message }}</div> 
                                            @enderror
                                            <button type="submit" class="btn btn-sm btn-submit">Gửi</button>
                                        </form>
                                    </div>
                                @endif

                                @foreach($comment->children as $child)
                                    <div class="comment-show" style="margin-left: 40px;">
                                        <a class="comment__avatar" href="#">
                                            <img class="img-circle img-sm"
                                                 src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                 alt="Profile Picture">
                                        </a>
                                        <div class="media-body">
                                            <div class="comment__content">
                                                <div>{{ $child->user->name }} <span class="text-muted text-sm">{{ $child->remaining_days }}</span></div>
                                                <div>{{ $child->content }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endempty
    </div>

    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            padding: 0.5rem;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 0.25rem;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</div>
