@extends('layouts.front')
@section('title')
    {{$brand->name}} | detail
@endsection
@section('content')
@livewire('front.brand-detail',['brand_id' => $brand->id])
@endsection