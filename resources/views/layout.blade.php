@extends('layouts.head')

@section('layout')

    <body class="d-flex text-center text-white bg-dark">
        <div class="cover-container d-flex w-100 mx-auto flex-column">
            <main class="h-100">
                @yield('content')
            </main>
        </div>
    </body>

    </html>
@endsection
