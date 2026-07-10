@extends('layouts.app')

@section('title', __('login').' | UAE Tourism')

@section('content')
    <x-auth-card :title="__('welcome_back')">
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="password" :value="__('password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember" class="inline-flex items-center gap-2 text-sm text-gray-600">
                    <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-gold focus:ring-gold">
                    {{ __('remember_me') }}
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-gold hover:underline">{{ __('forgot_password_q') }}</a>
            </div>

            <x-primary-button>{{ __('login') }}</x-primary-button>

            <p class="text-center text-sm text-gray-600">
                {{ __('no_account') }}
                <a href="{{ route('register') }}" class="text-gold font-semibold hover:underline">{{ __('register') }}</a>
            </p>
        </form>
    </x-auth-card>
@endsection
