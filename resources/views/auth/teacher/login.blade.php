<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">
    <title>Teacher's Login</title>
</head>

<body class="md:bg-gradient-to-r md:from-violet-500 md:to-fuchsia-500 w-screen h-screen sans-pro">
    <div class="md:flex md:flex-row h-full md:px-10 md:py-5">
        <div class="md:basis-1/2 flex flex-col justify-center items-center h-full bg-slate-100 md:rounded-l-lg">
            <div>
                <div class="md:flex md:justify-center md:items-center">
                    <!-- Logo goes here -->
                    <img src="{{ asset('images/radiant_logo.jpeg') }}" alt="" class="h-16 w-16 rounded-full shadow-xl">
                </div>
                <div class="mt-7">
                    <span class="font-bold text-2xl">Welcome back</span>
                    <div>
                        <span class="text-slate-500 text-sm">Welcome back! Please enter your details.</span>
                    </div>
                    @if (session('status'))
                        <div class="text-green-500 text-sm">{{ session('status') }}</div>
                    @endif
                </div>
                <form action="{{ route('teacher.login') }}" method="POST">
                    @csrf
                    <div class="mt-7">
                        <div>
                            <label for="Email" class="font-bold text-sm">Email</label><br />
                            <input autocomplete="email" type="email" value="{{ old('email') }}"
                                class="rounded-lg h-9 px-3 w-72 bg-transparent focus:shadow-md focus:outline-none border placeholder:font-light border-slate-300"
                                placeholder="Enter your email" name="email" required />
                            @error('email')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pt-3">
                            <label for="Password" class="font-bold text-sm">Password</label><br />
                            <input autocomplete="current-password" name="password" type="password"
                                placeholder="&middot&middot&middot&middot&middot&middot&middot&middot&middot&middot&middot"
                                class="rounded-lg h-9 w-72 px-3 bg-transparent focus:shadow-md focus:outline-none border placeholder:font-extrabold placeholder:text-2xl border-slate-300"
                                required />
                            @error('password')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="flex mt-4 justify-between items-baseline">
                        <div>
                            <input type="checkbox" name="remember" id="remember_me"
                                class="accent-slate-900 shadow-sm" />
                            <label for="Remember Me" class="text-sm font-bold pl-1 rounded-md">Remember Me</label>
                        </div>
                        <div>
                            @if (Route::has('teacher.password.request'))
                                <a href="{{ route('teacher.password.request') }}">
                                    <span
                                        class="text-sm font-bold hover:bg-gradient-to-r hover:from-violet-500 hover:to-fuchsia-500 hover:bg-clip-text hover:text-transparent">Forgot
                                        Password?</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="pt-8 flex justify-center">
                        <button
                            class="bg-slate-900 rounded-lg shadow-lg hover:shadow-none h-11 w-60 grow group hover:bg-gradient-to-r hover:from-violet-500 hover:to-fuchsia-500"
                            type="submit">
                            <span class="px-5 py-4 font-bold text-white text-sm">Login</span>
                        </button>
                    </div>
                </form>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="flex justify-center">
                        <button
                            class="border border-slate-900 rounded-lg shadow-lg hover:shadow-none grow h-11 group hover:bg-gradient-to-r hover:from-violet-500 hover:to-fuchsia-500"
                            type="button">
                            <span class="px-5 py-4 font-bold text-slate-900 text-sm">Go to User's login</span>
                        </button>
                    </a>
                </div>
                <div class="pt-5">
                    <span class="text-slate-500 text-sm text-center">Don't have an account? Contact an
                        administrator</span>
                </div>
            </div>
        </div>
        <div class="hidden md:block md:basis-1/2 bg-cover md:rounded-r-lg"
            style="background-image: url('{{ asset('images/office.jpg') }}')">
        </div>
    </div>
</body>

</html>
