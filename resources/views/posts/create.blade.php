@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>投稿作成</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="post-form">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-item">
                    <p class="form-label"><span class="label-required">必須</span>タイトル</p>
                    <input name="title" placeholder="タイトルの入力欄" class="form-input" value="{{ old('title') }}"/>
                </div>
                <div class="form-item">
                    <p class="form-label"><span class="label-required">必須</span>内容</p>
                    <textarea name="content" placeholder="内容の入力" class="form-textarea">{{ old('content') }}</textarea>
                </div>
                <div class="form-item">
                    <p class="form-label"><span class="label-required">必須</span>カテゴリー</p>
                    <select name="category_id" id="category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-item">
                    <p class="form-label"><span class="label-required">必須</span>画像</p>
                    <div class="image-preview" >
                        <img id="image-preview" src="#" alt="画像プレビュー" style="display: none;">
                    </div>
                    <input type="file" name="image" id="image" onchange="previewImage(this);">
                </div>
                    
                
                <div class="submit"><input type="submit" value="登録" /></div>
            </form>
        </div>
    </div>
@endsection



<script>
    function previewImage(input) {
    var preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // ファイルが選択されたらプレビューを表示
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        // ファイルが選択されていない場合、プレビューを非表示にする
        preview.style.display = 'none';
    }
}
</script>