@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>カテゴリー一覧</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @foreach ($categories as $category)
        <ul id="category-index">
            <li class="category-index-name"><a href="{{ route('category.show', ['category' => $category]) }}">{{ $category->name }}</a></li>
            <li class="category-index-edit"><a href="{{ route('category.edit', ['category' => $category]) }}">編集</a></li>
            <li class="category-index-delete">
                <form method="POST" action="{{ route('category.destroy', $category->id) }}" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" >削除する</button>
                </form>
            </li>
        </ul>
        @endforeach
    </div>
@endsection