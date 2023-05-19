@extends('layouts.front')
@section('title')
    home
@endsection
@section('content')
@livewire('front.home',['categoriesAll' => $categoriesAll])
@endsection