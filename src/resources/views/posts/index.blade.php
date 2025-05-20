@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div x-data="blogApp()" x-init="init()" class="container py-4">

    {{-- 投稿一覧 --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>投稿一覧</h2>
        <button type="button" class="btn btn-primary" @click="openPostModal">＋ 新規投稿</button>
    </div>
    <div class="list-group mb-4">
        <template x-for="post in posts" :key="post.id">
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                @click.prevent="openShowModal(post.id)">
                <span x-text="post.title"></span>
                <span class="badge bg-secondary" x-text="post.user?.name"></span>
            </a>
        </template>
    </div>

    {{-- 投稿モーダル --}}
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="confirmPost" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">新規投稿</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">タイトル</label>
                        <input type="text" class="form-control" x-model="postForm.title" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">内容</label>
                        <textarea class="form-control" x-model="postForm.body" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">内容確認</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 投稿内容確認モーダル --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="submitPost" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">内容確認</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <strong>タイトル：</strong>
                        <div x-text="postForm.title"></div>
                    </div>
                    <div>
                        <strong>内容：</strong>
                        <div class="border rounded p-2 bg-light" x-text="postForm.body"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="backToEdit()">戻る</button>
                    <button type="submit" class="btn btn-success">投稿する</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 詳細モーダル --}}
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" x-show="selectedPost">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel" x-text="selectedPost?.title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <span class="badge bg-secondary" x-text="selectedPost?.user?.name"></span>
                    </div>
                    <div x-text="selectedPost?.body"></div>
                </div>
                <div class="modal-footer">
                    <template x-if="selectedPost && selectedPost.user_id === userId">
                        <button class="btn btn-warning" @click="openEditModal()">編集</button>
                    </template>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 編集モーダル --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form @submit.prevent="updatePost" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">投稿を編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">タイトル</label>
                        <input type="text" class="form-control" x-model="editForm.title" maxlength="255" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">内容</label>
                        <textarea class="form-control" x-model="editForm.body" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Alpine.js本体 -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- blogApp定義はAlpine.jsより後、かつBladeで展開！ -->
<script>
function blogApp() {
    return {
        posts: [],
        postForm: { title: '', body: '' },
        editForm: { title: '', body: '' },
        selectedPost: null,
        userId: @json(auth()->id()),
        init() {
            this.fetchPosts();
        },
        fetchPosts() {
            fetch("{{ route('posts.index') }}?ajax=1")
                .then(res => res.json())
                .then(data => { this.posts = data; });
        },
        openPostModal() {
            this.postForm = { title: '', body: '' };
            new bootstrap.Modal(document.getElementById('postModal')).show();
        },
        confirmPost() {
            new bootstrap.Modal(document.getElementById('postModal')).hide();
            new bootstrap.Modal(document.getElementById('confirmModal')).show();
        },
        backToEdit() {
            new bootstrap.Modal(document.getElementById('confirmModal')).hide();
            new bootstrap.Modal(document.getElementById('postModal')).show();
        },
        submitPost() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch("{{ route('posts.index') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(this.postForm)
            })
            .then(res => {
                if (!res.ok) return res.text().then(text => { throw new Error(text); });
                return res.json();
            })
            .then(() => {
                this.fetchPosts();
                new bootstrap.Modal(document.getElementById('confirmModal')).hide();
            })
            .catch(e => {
                alert("エラー: " + e.message);
            });
        },
        openShowModal(id) {
            fetch(`/posts/${id}`)
                .then(res => res.json())
                .then(post => {
                    this.selectedPost = post;
                    new bootstrap.Modal(document.getElementById('showModal')).show();
                });
        },
        openEditModal() {
            this.editForm = {
                title: this.selectedPost.title,
                body: this.selectedPost.body
            };
            new bootstrap.Modal(document.getElementById('showModal')).hide();
            new bootstrap.Modal(document.getElementById('editModal')).show();
        },
        updatePost() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/posts/${this.selectedPost.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(this.editForm)
            })
            .then(res => {
                if (!res.ok) return res.text().then(text => { throw new Error(text); });
                return res.json();
            })
            .then(() => {
                this.fetchPosts();
                new bootstrap.Modal(document.getElementById('editModal')).hide();
            })
            .catch(e => {
                alert("エラー: " + e.message);
            });
        }
    }
}
</script>
@endsection