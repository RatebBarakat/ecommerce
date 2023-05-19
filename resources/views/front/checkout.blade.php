@extends('layouts.front')
@section('title')
    checkout 
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('css/checkout.css')}}">
@endsection
@section('content')
@livewire('front.checkout')
@endsection