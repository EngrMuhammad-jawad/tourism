@extends('layouts.app')

@section('title', __('my_account').' | UAE Tourism')

@section('content')
    <section class="pt-32 pb-24 bg-offwhite min-h-screen">
        <div class="container mx-auto px-6 max-w-3xl space-y-8">
            <div data-aos="fade-up">
                <h1 class="text-3xl font-bold text-deepblack mb-2">{{ __('my_account') }}</h1>
                <div class="w-24 h-1 bg-gold rounded-full"></div>
            </div>

            {{-- Profile information --}}
            <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up">
                <h2 class="text-xl font-bold text-deepblack mb-1">{{ __('profile_info') }}</h2>
                <p class="text-sm text-gray-500 mb-6">{{ __('profile_info_desc') }}</p>

                @if (session('status') === 'profile-updated')
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                        {{ __('saved') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('account.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name" :value="__('name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('phone')" />
                        <x-text-input id="phone" type="text" name="phone" :value="old('phone', $user->phone)" />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>

                    <div>
                        <x-input-label for="date_of_birth" :value="__('date_of_birth')" />
                        <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d'))" />
                        <x-input-error :messages="$errors->get('date_of_birth')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="address" :value="__('address')" />
                        <x-text-input id="address" type="text" name="address" :value="old('address', $user->profile?->address)" />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <div>
                        <x-input-label for="city" :value="__('city')" />
                        <x-text-input id="city" type="text" name="city" :value="old('city', $user->profile?->city)" />
                        <x-input-error :messages="$errors->get('city')" />
                    </div>

                    <div>
                        <x-input-label for="country" :value="__('country')" />
                        <x-text-input id="country" type="text" name="country" :value="old('country', $user->profile?->country)" />
                        <x-input-error :messages="$errors->get('country')" />
                    </div>

                    <div>
                        <x-input-label for="passport_no" :value="__('passport_no')" />
                        <x-text-input id="passport_no" type="text" name="passport_no" :value="old('passport_no', $user->profile?->passport_no)" />
                        <x-input-error :messages="$errors->get('passport_no')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-primary-button class="md:w-auto">{{ __('save') }}</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Update password --}}
            <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up">
                <h2 class="text-xl font-bold text-deepblack mb-1">{{ __('update_password') }}</h2>
                <p class="text-sm text-gray-500 mb-6">{{ __('update_password_desc') }}</p>

                @if (session('status') === 'password-updated')
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                        {{ __('password_updated') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4 max-w-md">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="current_password" :value="__('current_password')" />
                        <x-text-input id="current_password" type="password" name="current_password" autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('current_password')" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('new_password')" />
                        <x-text-input id="password" type="password" name="password" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('confirm_password')" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>

                    <x-primary-button class="md:w-auto">{{ __('update_password') }}</x-primary-button>
                </form>
            </div>
        </div>
    </section>
@endsection
