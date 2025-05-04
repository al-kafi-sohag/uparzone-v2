@extends('user.layout.master')

@section('title', 'Home')

@section('content')
<main class="overflow-y-auto flex-1 px-4 py-4">

    @include('user.home.create-post')

    @include('user.home.posts', ['posts' => []])


</main>
@endsection
