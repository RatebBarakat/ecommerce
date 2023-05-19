@extends('layouts.admin')
@section('title')
    edit | {{$category->name}}
@endsection
@section('content')
    @livewire('admin.category-edit', ['category' => $category])
@endsection