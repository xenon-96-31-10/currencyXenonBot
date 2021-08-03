@extends('layouts.app')

@section('content')
<div class="container">
  @if(auth()->user()->role == 'admin')
    <list-component type="chats"/>
  @endif
</div>
@endsection
