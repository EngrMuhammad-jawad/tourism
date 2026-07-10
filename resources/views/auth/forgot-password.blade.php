@extends('layouts.app')

@section('title', __('reset_password').' | UAE Tourism')

@section('content')
    <x-auth-card :title="__('reset_password')">
        <p class="text-sm text-gray-600 mb-4">{{ __('forgot_password_text') }}</p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <x-primary-button>{{ __('send_reset_link') }}</x-primary-button>

            <p class="text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-gold font-semibold hover:underline">{{ __('back_to_login') }}</a>
            </p>
        </form>
    </x-auth-card>
@endsection
