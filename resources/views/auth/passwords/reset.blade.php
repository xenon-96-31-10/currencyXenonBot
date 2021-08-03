@extends('layouts.app')
@section('title')Востановление пароля @endsection
@section('content')
<reset-component login-route="{{ route('login') }}" password-update-route="{{ route('password.update') }}" token={{$token}} email="{{$email}}"></reset-component>
@endsection
