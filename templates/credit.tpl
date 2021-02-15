@extends('layouts.layout', ['title' => 'Создание нового поста'])
@section('content')
<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <h3>Создать пост</h3>
    @include('posts.parts.form')
    <input type="submit" value="Создать пост" class="btn btn-outline-success">
</form>
@endsection



<form id="create-comment-form" data-attr="{{ route('comment.store') }}" method="post" action="" enctype="multipart/form-data">
    @csrf
    @include('comments.parts.form')


<div class="modal-content">
    <div class="modal-header">
        <h2 class="modal-title" id="comment-modal-label">{{ $modal_title }}</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" id="comment-modal-body">
        {{-- Заголовок отзыва --}}
        <div class="form-group">
            <label for="title">Заголовок:</label>
            <input name="title" id="title" type="text" class="form-control" required value="{{ $comment->title ?? '' }}">
        </div>
        {{-- Текст отзыва --}}
        <div class="form-group">
            <label for="comment_text">Текст отзыва:</label>
            <textarea name="comment_text" id="comment_text" rows="8" class="form-control" required>{{ $comment->comment_text ?? '' }}</textarea>
        </div>
        {{-- Города/города отзыва --}}
        @if($new_comment)
        <div class="form-group city-holder">
            <ul id="city-shell" class="city-shell"></ul>
        </div>
        <div class="form-group">
            <label for="cities-data">Выберите один или несколько городов (Нет выбора - все города):</label>
            <input id="cities-data" class="city-multiple form-control" type="search" placeholder="Начните писать ваш город ...">
            <select id="city-select" class="city-select" name="cities[]" multiple hidden>
            </select>
        </div>
        @endif
        {{-- Рейтинг --}}
        <div class="form-group">
            <label for="rating">Рейтинг (1-5):</label>
            <input id="rating" name="rating" type="number" step="1" min="1" max="5" class="form-control" value="{{ $comment->rating ?? '' }}" required>
        </div>
        {{-- Изображение --}}
        @if(!$new_comment)
        <div class="form-group">
            <input type="checkbox" id="img-checkbox" name="img_leave" checked>
            <label for="img-checkbox"> оставить изображение без изменения</label>
        </div>
        @endif
        <div id="img-input" class="form-group {{ $new_comment ? '' : 'd-none' }}">
            <label for="image">Прикрепите изображение (по желанию):</label><br>
            <input name="img" id="image" type="file">
        </div>
    </div>
    <div class="modal-footer">
        <button id="{{ $button_id }}" class="btn btn-outline-success">{{ $button_text }}</button>
    </div>
</div>
</form>

<form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>