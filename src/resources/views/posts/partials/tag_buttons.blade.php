@php
    $user = Auth::user();
@endphp
<form action="{{ route('posts.tag.toggle', $post->id) }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="tag" value="favorite">
    <button type="submit"
        class="btn btn-sm {{ $post->isTaggedBy($user, 'favorite') ? 'btn-warning' : 'btn-outline-warning' }}">
        ★ お気に入り
    </button>
</form>
<form action="{{ route('posts.tag.toggle', $post->id) }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="tag" value="read_later">
    <button type="submit"
        class="btn btn-sm {{ $post->isTaggedBy($user, 'read_later') ? 'btn-info' : 'btn-outline-info' }}">
        ⏰ 後で閲覧
    </button>
</form>