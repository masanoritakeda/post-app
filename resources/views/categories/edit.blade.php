@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>カテゴリー編集</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div id="category-edit">
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-item">
                    <p class="form-label">カテゴリー名</p>
                    <input type="text" name="name" class="form-input" value="{{ $category->name }}">
                </div>
                
                <div class="submit">
                    <input type="submit" value="更新"/>
                </div>
            </form>
        </div>
    </div>
@endsection