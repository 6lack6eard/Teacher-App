@extends('common.layout')

@section('title', 'Teacher App | Login')

@section('main')
<div class="login">
    <form id="" action="{{ route('teacher.login') }}" method="post">
        <h4 class="text-center">Teacher Login</h4>
        @csrf

        <div class="form-grp">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}">
        </div>
        <div class="form-grp">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}">
        </div>
        <div class="button-div">
            <button type="submit">Login</button>
        </div>
    </form>
</div>

@endsection

@section('script')
@endsection