<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.verified') }}">
        @csrf

        <!-- Phone no -->
        <div>
            @if (session('success'))
                <div style="color:green">
                    {{session('success')}}
                </div>
            @endif
            @if (session('error'))
                <div style="color:red">
                    {{session('error')}}
                </div>
            @endif
            <input type="hidden" name="user_id" value={{$user_id}}>
            {{-- <x-text-input id="user_id" class="block mt-1 w-full" type="text" name="otp" :value={{$user_id}} required autofocus autocomplete="phone_no" /> --}}
            <x-input-label for="otp" :value="__('OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" :value="old('otp')" required autofocus autocomplete="phone_no" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <!-- Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">


            <x-primary-button class="ms-3">
                {{ __('Verified Otp') }}
            </x-primary-button>
        </div>
    </form>
    <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
</x-guest-layout>
