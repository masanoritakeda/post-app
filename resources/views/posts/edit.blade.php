@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>投稿編集</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="post-edit">
            <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-item">
                    <p class="form-label">タイトル</p>
                    <input type="text" class="form-input" name="title" value="{{ $post->title }}">
                </div>
                
                <div class="form-item">
                    <p class="form-label">内容</p>
                    <textarea class="form-textarea"  name="content">{{ $post->content }}</textarea>
                </div>

                <div class="form-item">
                    <label for="category">カテゴリ</label>
                    <select name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id === $post->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($post->image)
                    <div class="form-item">
                        <p class="form-label">現在の画像</p>
                        <img src="{{ asset('images/' . $post->image) }}" alt="現在の画像">
                    </div>
                @endif

                <div class="form-item">
                    <label for="image">画像</label>
                    <input type="file" name="image" id="image">
                </div>
                
                <div class="submit">
                    <input type="submit" value="更新"/>
                    <a href="{{ route('post.show', ['post' => $post]) }}" class="link">詳細ページ</a>
                </div>
            </form>
        </div>
    </div>
@endsection