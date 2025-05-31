@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endsection

@section('content')
    <div class="py-12">
        <div class="space-y-6">
            <div>
                <h3 class="profile-title">{{ __('messages.User Management') }}</h3>
            </div>
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="profile-table">
                    <thead>
                        <tr>
                            <th>{{ __('messages.Name') }}</th>
                            <th>{{ __('messages.Email') }}</th>
                            <th>{{ __('messages.Role') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}">
                                        {{ __('messages.Edit') }}
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure?');"
                                                style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                {{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection