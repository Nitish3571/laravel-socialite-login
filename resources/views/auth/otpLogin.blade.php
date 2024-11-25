<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.login') }}">
        @csrf

        <!-- Phone no -->
        <div>
            <x-input-label for="phone" :value="__('Phone No')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone_no" :value="old('phone_no')" required autofocus autocomplete="phone_no" />
            <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
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
                {{ __('Send Otp') }}
            </x-primary-button>
        </div>
    </form>
    <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
</x-guest-layout>
