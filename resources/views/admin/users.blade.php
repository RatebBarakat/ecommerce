@extends('layouts.admin')
@section('content')
    @livewire('admin.users')
@endsection
@section('title')
    users
@endsection
@section('js')
<script type="text/javascript">
  window.livewire.on('open_add_modal', () => {
    $('#addUserModal').modal('show')
  })
  window.livewire.on('addUser', () => {
    $('#addUserModal').modal('hide')
  });
  window.livewire.on('close_add_modal', () => {
    $('#addUserModal').modal('hide')
  })

</script>
@endsection
