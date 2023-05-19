@extends('layouts.front')
@section('title')
    {{$category->name}} | detail
@endsection
@section('content')
@livewire('front.category-detail',['category_id' => $category->id])
@endsection