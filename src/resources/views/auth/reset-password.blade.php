@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/reset-pass.css') }}">
@endsection

@section('content')
        <div class="p-6">
            @if (session('status'))
                <div class="success-alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-6">
                <div>
                    <h3 class="profile-title">
                        {{ __('messages.Change Password') }}
                    </h3>
                    <p class="profile-desc">
                        {{ __('messages.Ensure your account is using a secure password.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('user-password.update') }}" class="profile-form space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="profile-view-label">
                            {{ __('messages.Current Password') }}
                        </label>
                        <input type="password"
                                name="current_password"
                                id="current_password"
                                required>
                        @error('current_password')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="profile-view-label">
                            {{ __('messages.New Password') }}
                        </label>
                        <input type="password"
                                name="password"
                                id="password"
                                required>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="profile-view-label">
                            {{ __('messages.Confirm Password') }}
                        </label>
                        <input type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required>
                    </div>

                    <div class="flex items-center justify-end pt-6">
                        <button type="submit"
                                class="submit-btn">
                            {{ __('messages.Change Password') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex items-center justify-end pt-6">
                <a href="{{ route('profile.show') }}" class="text-sm text-blue-500 underline">
                    {{ __('messages.Back to My Page') }}
                </a>
            </div>
        </div>
@endsection
