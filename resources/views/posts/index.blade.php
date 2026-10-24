
@extends('layouts.app')

@section('content')

<div class="row align-items-center mb-4">

    {{-- Empty column: visible only on medium screens and larger --}}
    <div class="col-md-4 d-none d-md-block"></div>

    {{-- Page title --}}
    <div class="col-12 col-md-4 text-center">
        <h1 class="mb-0">Posts</h1>
    </div>

    {{-- Create Post action --}}
    <div class="col-12 col-md-4 text-center text-md-end mt-3 mt-md-0">

        @auth
            <a href="{{ route('post.create') }}">
                Create Post
            </a>
        @endauth

    </div>

</div>

@if ($posts->isEmpty())

    <p>Non ci sono post</p>

@else

    <div class="row">

        @foreach ($posts as $post)

            <div class="col-12 col-md-6 col-lg-4 mb-4">

                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title mb-2 text-center">
                            {{ $post->title }}
                        </h4>

                        <p class="card-text mb-3">
                            {{ Str::limit($post->content, 50) }}
                        </p>

                        <a href="{{ route('post.show', $post->id) }}">
                            Leggi post completo
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection

