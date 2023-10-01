@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>投稿詳細</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div id="post-show">
            <div class="post-show-img"><img src="{{ asset('images/' . $post->image) }}"></div>
            <div id="post-show-text">
                <h3>{{ $post->title }}</h3>
                <p>投稿者: {{ $post->user->name }}</p>
                @if($post->category)
                    <p>カテゴリ: {{ $post->category->name }}</p>
                @endif
                <p class="post-show-content">{{ $post->content }}</p>
            </div>
            @auth
                @if(auth()->user()->id === $post->user_id)
                <div id="post-show-other">
                    <a href="{{ route('post.edit', ['post' => $post]) }}" class="link">編集する</a>
                    <form method="POST" action="{{ route('post.destroy', $post->id) }}" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="link">削除する</button>
                    </form>
                </div>
                @endif
            @endauth
        </div>
        <div class="comment">
            <form method="POST" action="{{ route('comment.store', $post->id) }}">
                @csrf
                <input type="hidden" name='post_id' value="{{$post->id}}">
                <div class="comment-add">
                    <h4>コメントを追加</h4>
                    <textarea name="body" id="body" class="form-control"></textarea>
                </div>
                <div class="comment-add-button">
                    <button type="submit" class="btn btn-primary">コメントする</button>
                </div>
            </form>
            <ul class="comment-delete">
            @foreach ($post->comments as $comment)
                <li>
                    <p><strong>{{ $comment->user->name }}:</strong></p>
                    <p>{{ $comment->body }}</p>
                    @if (auth()->check() && $comment->user_id === auth()->user()->id)
                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('本当にこのコメントを削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <div class="comment-delete-button"><button type="submit" class="btn btn-danger">コメントを削除</button></div>
                    </form>
                    @endif
                </li>
            @endforeach
            </ul>
            
        </div>
        
    </div>
@endsection