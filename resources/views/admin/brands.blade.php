@extends('layouts.admin')
@section('title')
    brands
@endsection
@section('content')
    @livewire('admin.brands')
@endsection
@section('js')
<script type="text/javascript">

  window.livewire.on('addBrand', () => {
    $('#addBrandModal').modal('hide')
  });
  window.livewire.on('closeAddModal', () => {
    $('#addBrandModal').modal('hide')
  });
  
  window.livewire.on('openAddModal', () => {
    $('#addBrandModal').modal('show')
  })
</script>
@endsection
