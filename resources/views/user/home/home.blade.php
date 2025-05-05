@extends('user.layout.master')

@section('title', 'Home')

@push('styles')
<style>
    /* Optional fade-in effect when image loads */
    .lazyload {
        opacity: 0.9;
        transition: opacity 300ms ease-in;
    }
    .lazyloaded {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<main class="overflow-y-auto flex-1 px-4 py-4">

    @include('user.home.create-post')

    @include('user.home.posts', ['posts' => $posts])


</main>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
@endpush

