<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials.head', ['pageTitle' => $pageTitle, 'metaTitle' => $metaTitle])

<body>
    <nav class="nav-container">
     @include('partials.menu')
     </nav>

    <div class="alert-container">
        @include('partials.messages')
    </div>

    <div class="container py-4">

        @yield('content')

    </div>

       
</body>

</html>
