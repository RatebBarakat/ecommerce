<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Categoires [{{$categories->total()}}]</h6>
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
                        <select name="perpage" id="perpage" wire:model="perPage" class="form-control">
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
          add cateogry
        </button>
        
          

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>visibility</th>
                        <th>ads</th>
                        <th>created at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.remove wire:target="filteringData">
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            @if ($category->visibility)
                                <span style="white-space: nowrap;width: fit-content;color: green;background: rgba(0, 255, 0, 0.3)" class="p-1 alert alert-success">
                                    visible
                                </span>
                            @else
                            <span style="white-space: nowrap;width: fit-content;color: red;background: rgba(255, 0, 0, 0.1);border-color: rgba(255, 0, 0, 0.1)" class="p-1 alert alert-success">
                                visible
                            </span>
                            @endif
                        </td>
                        <td>
                            @if ($category->ads)
                            <span style="white-space: nowrap;width: fit-content;color: green;background: rgba(0, 255, 0, 0.3)" class="p-1 alert alert-success">
                                allow
                            </span>
                        @else
                        <span style="white-space: nowrap;width: fit-content;color: red;background: rgba(255, 0, 0, 0.1);border-color: rgba(255, 0, 0, 0.1)" class="p-1 alert alert-success">
                            un allow
                        </span>
                        @endif
                        </td>
                        <td>{{$category->created_at}}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{route('admin.categories.edit',[$category->id])}}" class="btn btn-outline-primary btn-sm">
                                  edit
                                </a>
                                
                                <button class="btn btn-outline-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()"
                                wire:click="deleteCategory({{$category->id}})" wire:loading.attr="disabled">delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6">no categories</td>
                        </tr>
                    @endforelse
                </tbody>
                <tr class="loading" wire:loading wire:target="filteringData">
                    <td colspan="3">loading...</td>
                </tr>
            </table>
        </div>
        {{-- add user  --}}
        <div wire:ignore.self class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addCategoryModalLabel">add category</h5>
                  <button type="button" 
                  class="close btn btn-outline-danger btn-sm" onclick="$('#addCategoryModal').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form wire:submit.prevent="addCategory" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                      {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
                        <div class="form-group">
                            <label for="email">name<span style="color:red">*</span></label>
                            @error('name')
                                <span class="text-sm text-danger">{{$message}}</span>
                            @enderror
                            <input class="form-control"
                             wire:model.defer="name" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="password">visibility<span style="color:red">*</span></label>  
                                                        @error('name')
                                <span class="text-sm text-danger">{{$visibility}}</span>
                            @enderror
                            <input wire:model.defer="visibility" type="checkbox" name="visibility" id="visibility">
                        </div>
                        <div class="form-group">
                            <label for="password">ads<span style="color:red">*</span></label>
                                                        @error('name')
                                <span class="text-sm text-danger">{{$ads}}</span>
                            @enderror
                            <input  wire:model.defer="ads" 
                             type="checkbox" name="ads" id="ads">
                        </div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('#addCategoryModal').modal('hide')">Close</button>
                        <button type="submit" class="btn btn-primary">add</button>
                      </div>
                </form>
              </div>
            </div>
          </div>

   
          {{ $categories->links() }}
       </div>
</div>