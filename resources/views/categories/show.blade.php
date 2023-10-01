@extends('layouts.app')

@section('content')
<div class="container">
    <h1>カテゴリー名：{{ $category->name }}</h1>

    <div id="post-list">
        <ul class="list-group">
            @foreach ($posts as $post)
            <a href="{{ route('post.show', ['post' => $post]) }}">
                <li>
                    <img src="{{ asset('images/' . $post->image) }}">
                    <div class="list-group-content">
                        <p>{{ $post->created_at->format('m月d日') }}</p>
                        @foreach ($post->categories as $category)
                            <p class="list-group-category">{{ $category->name }}</p>
                        @endforeach
                    </div>
                    <p class="list-group-title">{{ $post->title }}</p>
                </li>
            </a>
            @endforeach
        </ul>
    </div>    
</div>
@endsection