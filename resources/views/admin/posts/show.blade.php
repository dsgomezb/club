@extends('admin.layouts.app')

@section('section', 'Posts')

@section('action', 'Listar')

@section('icon', 'file-alt')

@section('widget-body')
    <h1>{{ $post->title }}</h1>

    <p>{!! nl2br($post->content) !!}</p>

    @comments(['model' => $post])
@endsection

@section('scripts')
    <script src="/backend/js/app/Posts.js"></script>
@endsection
