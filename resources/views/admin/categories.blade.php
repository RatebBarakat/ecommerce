@extends('layouts.admin')
@section('title')
    categories
@endsection
@section('content')
    @livewire('admin.categories')
@endsection
@section('js')
<script type="text/javascript">

  window.livewire.on('addCategory', () => {
    $('#addCategoryModal').modal('hide')
  });
  window.livewire.on('closeAddModal', () => {
    $('#addCategoryModal').modal('hide')
  });
  
  window.livewire.on('openAddModal', () => {
    $('#addCategoryModal').modal('show')
  })
</script>
@endsection
