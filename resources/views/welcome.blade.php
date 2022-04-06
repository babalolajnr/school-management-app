<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">
    <title>RMS</title>
</head>

<body class="flex justify-center items-center h-screen sans-pro">
    <div class="flex flex-col justify-center items-center -mt-16 mx-5 md:mx-0">
        <div class="h-32 w-32 rounded-full bg-cover"
            style="background-image: url({{ asset('images/radiant_logo.jpeg') }})">
        </div>
        <h1 class="font-bold md:text-6xl text-3xl  mt-3 text-center">Radiant Minds School Portal</h1>
        <div class="flex mt-4">
            <a href="{{ route('login') }}">
                <button
                    class="border border-slate-900 rounded-lg shadow-lg hover:shadow-none grow h-11 group hover:bg-slate-800"
                    type="button">
                    <span class="px-5 py-4 font-bold text-slate-900 hover:text-white text-sm">Login</span>
                </button>
            </a>

            <a href="{{ route('teacher.login') }}">
                <button
                    class="border ml-4 border-slate-900 rounded-lg shadow-lg hover:shadow-none grow h-11 group hover:bg-slate-800"
                    type="button">
                    <span class="px-5 py-4 font-bold text-slate-900 hover:text-white text-sm">Teacher's login</span>
                </button>
            </a>
        </div>
    </div>

</body>

</html>
