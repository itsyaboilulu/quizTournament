@php
    $page_title = 'Login';
@endphp
@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/auth.min.css')}}" />
@endsection
@section('content')
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">

        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id='form'>
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center cb-container">{{ __('Remember me') }}
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4" style="text-align:center">
                <a class="button" id="login">Login</a>
                <a class="button btn-green" href="register">Register</a>
            </div>

        </form>
    </x-jet-authentication-card>
</x-guest-layout>

@endsection
@section('script')
    <script>
        document.getElementById('login').addEventListener("click", function(){
            document.getElementById('form').submit();
        });
    </script>
@endsection
