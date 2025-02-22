<div>
    <h1 class="text-xl font-bold mb-4">Quản lý Bài Viết</h1>

    <input type="text" wire:model="title" placeholder="Tiêu đề" class="border p-2">
    <textarea wire:model="content" placeholder="Nội dung" class="border p-2"></textarea>

    @if($isEdit)
        <button wire:click="update" class="bg-green-500 text-white p-2">Cập nhật</button>
    @else
        <button wire:click="create" class="bg-blue-500 text-white p-2">Đăng bài</button>
    @endif

    <h2 class="mt-6 text-lg font-bold">Danh sách bài viết</h2>
    <ul>
        @foreach($posts as $post)
            <li class="border p-2 mt-2">
                <strong>{{ $post->title }}</strong>
                <p>{{ $post->content }}</p>
                <button wire:click="edit({{ $post->id }})" class="text-green-500">Sửa</button>
                <button wire:click="delete({{ $post->id }})" class="text-red-500">Xóa</button>
            </li>
        @endforeach
    </ul>
</div>
