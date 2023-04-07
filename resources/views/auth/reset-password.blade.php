<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">
    <title>Reset Password</title>
</head>

<body class="bg-gradient-to-r from-violet-500 to-fuchsia-900 w-screen flex h-screen sans-pro justify-center items-center">
    <div class="bg-slate-200 md:w-1/3 rounded-lg shadow-lg mx-5 md:mx-0">
        <div class="px-4 py-5">
            <div class="text-sm">
                {{ __('Reset your password here') }}
            </div>
            <form action="{{ route('password.update') }}" method="POST" class="mt-4">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="Email" class="font-bold text-sm">Email</label><br />
                    <input autocomplete="email" autofocus name="email" value="{{ old('email', $request->email) }}" type="email" placeholder="Enter your email" class="rounded-lg w-full px-3 bg-transparent focus:shadow-md focus:outline-none border placeholder:font-light py-1 border-slate-300" required />
                    @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="password" class="font-bold text-sm">Password</label><br />
                    <input name="password" type="password" placeholder="Enter a new password" class="rounded-lg w-full px-3 bg-transparent focus:shadow-md focus:outline-none border placeholder:font-light py-1 border-slate-300" required />
                    @error('password')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="password_confirmation" class="font-bold text-sm">Confirm Password</label><br />
                    <input name="password_confirmation" type="password" placeholder="Confirm Password" class="rounded-lg w-full px-3 bg-transparent focus:shadow-md focus:outline-none border placeholder:font-light py-1 border-slate-300" required />
                    @error('password_confirmation')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-4 flex flex-row-reverse">
                    <button type="submit" class="bg-slate-900 text-slate-200 text-sm group hover:bg-gradient-to-r hover:from-violet-500 hover:to-fuchsia-500 py-2 px-4 rounded-lg">
                        {{ __('Reset Password') }}
                    </button>
            </form>
        </div>
    </div>
</body>

</html>