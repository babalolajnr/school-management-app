<x-guest-layout>
    <div class="h-screen w-screen flex justify-center items-center sans-pro">
        <form class="lg:md:w-1/4 w-1/2  rounded-lg shadow-lg" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="my-7 mx-5 flex flex-col space-y-3">
                <div>
                    <div class="flex flex-col -space-y-5">
                        <label for="first_name" class="font-bold text-sm">First name</label><br />
                        <input autocomplete="first_name" type="text" value="{{ old('first_name') }}"
                            class="rounded-lg h-9 px-3 grow focus:outline-green-500 bg-transparent border placeholder:font-light border-slate-300"
                            placeholder="Enter your first_name" name="first_name" />
                    </div>
                    @error('first_name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="flex flex-col -space-y-5">
                        <label for="last_name" class="font-bold text-sm">Last name</label><br />
                        <input autocomplete="last_name" type="text" value="{{ old('last_name') }}"
                            class="rounded-lg h-9 px-3 grow focus:outline-green-500 bg-transparent border placeholder:font-light border-slate-300"
                            placeholder="Enter your last_name" name="last_name" />
                    </div>
                    @error('last_name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="flex flex-col -space-y-5">
                        <label for="email" class="font-bold text-sm">Email</label><br />
                        <input autocomplete="email" type="email" value="{{ old('email') }}"
                            class="rounded-lg h-9 px-3 grow focus:outline-green-500 bg-transparent border placeholder:font-light border-slate-300"
                            placeholder="Enter your email" name="email" />
                    </div>
                    @error('email')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="flex flex-col -space-y-5">
                        <label for="password" class="font-bold text-sm">Password</label><br />
                        <input autocomplete="password" type="password" value="{{ old('password') }}"
                            class="rounded-lg h-9 px-3 grow focus:outline-green-500 bg-transparent border placeholder:font-light border-slate-300"
                            placeholder="Retype password" name="password" />
                    </div>
                    @error('password')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="flex flex-col -space-y-5">
                        <label for="password_confirmation" class="font-bold text-sm">Comfirm Password</label><br />
                        <input autocomplete="password" type="password" value="{{ old('password_confirmation') }}"
                            class="rounded-lg h-9 px-3 grow focus:outline-green-500 bg-transparent border placeholder:font-light border-slate-300"
                            placeholder="Enter your password_confirmation" name="password_confirmation" />
                    </div>
                    @error('password_confirmation')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="flex mt-5">
                <button type="submit" class="grow bg-green-500 py-3 rounded-b-lg hover:bg-opacity-90">Submit</button>
            </div>
        </form>
    </div>
</x-guest-layout>
