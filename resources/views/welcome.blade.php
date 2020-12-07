@extends('layouts.app')

@section('content')
    {{-- lesson14 --}}
    @if (Auth::check())
        {{ Auth::user()->name }}
    @else
    {{-- ↑ --}}
    
    <div class="center jumbotron">
        <div class="text-center">
            <h1>タスク管理</h1>
            {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route(
            'signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
        </div>
    </div>
    @endif
@endsection