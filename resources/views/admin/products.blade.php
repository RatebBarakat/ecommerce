@extends('layouts.admin')
@section('content')
    @livewire('admin.products')
@endsection
@section('title')
    Products
@endsection
@section('js')
<script type="text/javascript">
  window.livewire.on('open_add_modal', () => {
    $('#addProductModal').modal('show')
  })
  window.livewire.on('addProduct', () => {
    $('#addProductModal').modal('hide')
  });
  window.livewire.on('close_add_modal', () => {
    $('#addProductModal').modal('hide')
  })

</script>
@endsection
