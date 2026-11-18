@extends('layouts.app')

@section('title', 'Login - Klinik Sehat')

@section('content')
<div class="card" style="max-width:420px;margin:40px auto;padding:24px;">
    <h2>Login</h2>
    <p class="teks-redup">Masuk untuk mengakses data Klinik Sehat</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-grid">
            <div class="full">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="@error('email') input-error @enderror" autofocus>
                @error('email') <small class="error-text">{{ $message }}</small> @enderror
            </div>

            <div class="full">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       class="@error('password') input-error @enderror">
                @error('password') <small class="error-text">{{ $message }}</small> @enderror
            </div>

            <div class="full">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </div>
    </form>
</div>
@endsection
