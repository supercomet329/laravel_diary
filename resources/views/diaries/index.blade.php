@extends('layouts.app')

@section('title')
一覧
@endsection

@section('content')
<a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">
    新規投稿
</a>
@foreach ($diaries as $diary)
    <div class="mt-4 p-3 border border-primary">
        <p>{{ $diary->title }}</p>
        <p>{{ $diary->body }}</p>
        <p>{{ $diary->created_at }}</p>
        @if (Auth::check() && Auth::user()->id === $diary->user_id)
            <a class="btn btn-success" href="{{ route('diary.edit', ['id' => $diary->id]) }}">編集</a>
            <form action="{{ route('diary.destroy', ['id' => $diary->id]) }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-danger">削除</button>
            </form>
        @endif
        <div class=" mt-3 ml-3 js-like">
            <i class="far fa-heart fa-lg text-danger"></i>
            {{-- <i class="fas fa-heart fa-lg text-danger"></i> --}}
            <span>200</span>
        </div>
    </div>
@endforeach
@endsection