@extends('layouts.admin')
@section('title')
    edit | {{$brand->name}}
@endsection
@section('content')
    @livewire('admin.brand-edit', ['brand' => $brand,'category' => $brand->category])
@endsection