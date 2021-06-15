<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Radiant Minds School') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Nunito';
        }

    </style>
</head>

{{-- <body class="antialiased">
    <div
        class="lg:relative lg:flex lg:items-top lg:justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        @if (Route::has('login'))
            <div class="lg:fixed lg:top-0 lg:right-0 lg:px-6 lg:py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm dark:text-white text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-white underline">Login</a>
                    <a href="{{ route('teacher.login') }}"
                        class="ml-4 text-sm text-gray-700 dark:text-white underline">Teacher Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-white underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="sm:flex sm:justify-center sm:items-center sm:h-2/4">
            <div class="sm:h-2/4">
                <h1 class="text-center lg:text-5xl dark:text-white text-gray-900 font-bold">RADIANT MINDS SCHOOL</h1>
            </div>
        </div>
    </div>
</body> --}}

<body class="antialiased">
    <div class="pt-60 lg:relative lg:flex lg:items-top lg:justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="hidden lg:block">
            <div class="lg:fixed lg:top-0 lg:right-0 lg:px-6 lg:py-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm dark:text-white text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-white underline">Login</a>
                    <a href="{{ route('teacher.login') }}"
                        class="ml-4 text-sm text-gray-700 dark:text-white underline">Teacher's Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-white underline">Register</a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="lg:mt-8">
            <h1 class="font-bold text-lg text-center lg:text-5xl dark:text-white text-gray-900">RADIANT MINDS SCHOOL
            </h1>
        </div>
        <div class="lg:hidden font-thin text-sm flex">
            <div class="mx-auto">
                <div class="py-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm dark:text-white text-gray-700 underline"><button
                                class="btn-blue">Dashboard</button></a>
                    @else
                        <a href="{{ route('login') }}"><button class="btn-blue">Login</button></a>
                        <a href=""><button class="btn-blue">Register</button></a>
                    </div>
                    @if (Route::has('register'))
                        <a href="{{ route('teacher.login') }}" class="block"><button class="btn-blue">Teacher's
                                Login</button></a>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</body>

</html>
