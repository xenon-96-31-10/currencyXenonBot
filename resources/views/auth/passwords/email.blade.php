@extends('layouts.app')
@section('title')Отправка ссылки на востановление пароля@endsection
@section('content')
<reset-link-component password-email-route="{{ route('password.email') }}"></reset-link-component>
@endsection
