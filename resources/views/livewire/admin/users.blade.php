<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">users [{{$users->total()}}]</h6>
    </div>
    <div class="card-body">
@if (session()->has('edit_success'))
    <div class="alert alert-success notification">
      {{session()->get('edit_success')}}
    </div>
@endif
        <div class="row filters border-main my-2 w-100 mx-auto" style="justify-content: space-between">
            <div class="col-12 p-2 mb-1" style="border-bottom: 1px solid var(--border-color)">
                filters:
            </div>
            <div class="col-12 form-group col-sm-6 flex-end">
                <input type="text" name="search" id="search" class="form-control"
                 placeholder="search users ..." wire:model="search" wire:input="filteringData">
            </div>
            <div class="col-sm-3 col-12">per page:
                <div class="form-group">
                        <select name="perpage" id="perpage" wire:model="per_page" class="form-control">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                </div>
            </div>
        </div>
        <button  
        type="button" class="btn btn-outline-primary btn-sm mb-2"
          wire:click="showAddModal">
          add user
        </button>
        
          

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>email</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.remove wire:target="filteringData">
                    @forelse ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{route('admin.users.edit',[$user->id])}}" class="btn btn-outline-primary btn-sm">
                                  edit
                                </a>
                                
                                <button class="btn btn-outline-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                                wire:click="deleteUser({{$user->id}})" wire:loading.attr="disabled">delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="3">no users</td>
                        </tr>
                    @endforelse
                </tbody>
                <tr class="loading" wire:loading wire:target="filteringData">
                    <td colspan="3">loading...</td>
                </tr>
            </table>
        </div>
        {{-- add user  --}}
        <div wire:ignore.self class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addUserModalLabel">add user</h5>
                  <button type="button" 
                  class="close btn btn-outline-danger btn-sm" wire:click="closeAddModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form wire:submit.prevent="addUser" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                      @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                        <div class="form-group">
                            <label for="email">name<span style="color:red">*</span></label>
                            
                            <input class="form-control"
                             wire:model.defer="name" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">email<span style="color:red">*</span></label>
                            
                            <input class="form-control"
                             wire:model="email" type="email" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="password">password<span style="color:red">*</span></label>
                                                  
                            <input class="form-control" wire:model="password" type="password" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password">password confirm<span style="color:red">*</span></label>
                                                  
                            <input class="form-control"  wire:model.defer="password_confirm" 
                             type="password" name="password_confirm" id="password_confirm">
                        </div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeAddModal">Close</button>
                        <button type="submit" class="btn btn-primary">add</button>
                      </div>
                </form>
              </div>
            </div>
          </div>

   
          {{ $users->links() }}
       </div>
</div>