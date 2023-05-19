@extends('layouts.admin')
@section('title')
    edit | {{$user->name}}
@endsection
@section('content')
    @livewire('admin.user-edit', ['user' => $user])
@endsection