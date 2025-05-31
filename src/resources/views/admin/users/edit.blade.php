@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/user-edit.css') }}">
@endsection

@section('content')
        <h3 class="profile-title">{{ __('messages.Edit User') }}</h3>
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="profile-view-label">{{ __('messages.Name') }}</label>
                    <input type="text" name="name" class="profile-input" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="profile-view-label">{{ __('messages.Email') }}</label>
                    <input type="email" name="email" class="profile-input" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="profile-view-label">{{ __('messages.Role') }}</label>
                    <select name="role" class="profile-input">
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="special" {{ old('role', $user->role) == 'special' ? 'selected' : '' }}>Special</option>
                        <option value="general" {{ old('role', $user->role) == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                    @error('role')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div class="pt-6 text-right">
                    <a href="{{ route('admin.users.index') }}" class="submit-btn mr-4">{{ __('messages.Back') }}</a>
                    <button type="submit" class="submit-btn">{{ __('messages.Save') }}</button>
                </div>
            </div>
        </form>
@endsection