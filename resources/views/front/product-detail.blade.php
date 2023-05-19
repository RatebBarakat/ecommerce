@extends('layouts.front')
@section('title')
    {{$product->name}} | detail
@endsection
@section('content')
@livewire('front.product-detail', ['product' => $product])
@endsection