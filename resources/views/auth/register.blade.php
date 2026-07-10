@extends('layouts.app')

@section('title', __('register').' | UAE Tourism')

@section('content')
    <x-auth-card :title="__('create_account')">
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('name')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('phone')" />
                <x-text-input id="phone" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" />
            </div>

            <div>
                <x-input-label for="password" :value="__('password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('confirm_password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <x-primary-button>{{ __('register') }}</x-primary-button>

            <p class="text-center text-sm text-gray-600">
                {{ __('already_registered') }}
                <a href="{{ route('login') }}" class="text-gold font-semibold hover:underline">{{ __('login') }}</a>
            </p>
        </form>
    </x-auth-card>
@endsection
