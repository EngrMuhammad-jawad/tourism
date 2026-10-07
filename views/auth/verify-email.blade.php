@extends('layouts.app')

@section('title', __('verify_email_title').' | UAE Tourism')

@section('content')
    <x-auth-card :title="__('verify_email_title')">
        <p class="text-sm text-gray-600 mb-4">{{ __('verify_email_text') }}</p>

        @if (session('status') === 'verification-link-sent')
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ __('verification_sent') }}
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>{{ __('resend_verification') }}</x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gold underline">{{ __('logout') }}</button>
            </form>
        </div>
    </x-auth-card>
@endsection
