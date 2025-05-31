@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage_edit.css') }}">
@endsection

@section('content')
<div class="py-12">
    <div class="p-6">
        @if (session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div>
                        <h3 class="profile-title">
                        {{ __('messages.Profile Information') }}
                        </h3>
                        <p class="profile-desc">
                        {{ __('messages.Update your account\'s profile information.') }}
                        </p>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="profile-view-label">
                            {{ __('messages.Name') }}
                        </label>
                        <input type="text"
                            name="name"
                            id="name"
                            class="profile-view-value"
                            value="{{ old('name', auth()->user()->name) }}"
                            required>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="profile-view-label">
                            {{ __('messages.Email') }}
                        </label>
                        <input type="email"
                            name="email"
                            id="email"
                            class="profile-view-value"
                            value="{{ old('email', auth()->user()->email) }}"
                            required>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label for="avatar" class="profile-view-label">
                            {{ __('messages.Profile Image') }}
                        </label>
                        <div class="profile-avatar-block">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="profile-avatar-img">
                            @endif
                            <input type="file"
                                name="avatar"
                                id="avatar">
                        </div>
                        @error('avatar')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="profile-view-label">
                            {{ __('messages.Bio') }}
                        </label>
                        <textarea name="bio"
                                id="bio"
                                class="profile-view-value"
                                rows="4">{{ old('bio', auth()->user()->bio) }}</textarea>
                        @error('bio')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Save Button -->
                    <div class="flex items-center justify-end pt-6">
                        <button type="submit" class="submit-btn">
                            {{ __('messages.Save Changes') }}
                        </button>
                    </div>
                </form>

        <div class="flex items-center justify-end pt-6">
            <a href="{{ route('profile.show') }}" class="submit-btn">
                {{ __('messages.Back to Profile') }}
            </a>
        </div>
    </div>
</div>
@endsection