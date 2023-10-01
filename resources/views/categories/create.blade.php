@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>カテゴリー作成</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="category-form">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="form-item">
                    <p class="form-label">カテゴリー名</p>
                    <input type="text" class="form-input" name="name" required>
                </div>
                <div class="submit"><input type="submit" value="登録" /></div>
            </form>
        </div>
    </div>
@endsection