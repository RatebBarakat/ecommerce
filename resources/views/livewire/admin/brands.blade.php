<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">brands [{{$brands->total()}}]</h6>
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
                <input type="search" name="search" id="search" class="form-control"
                 placeholder="search brands ..." wire:model="search" 
                 wire:input="filteringData">
            </div>
            <div class="col-sm-3 col-12">category:
                <div class="form-group">
                        <select name="categoryFilter" id="categoryFilter" wire:model="categoryFilter" class="form-control">
                            <option value="{{null}}"></option>
                            @foreach ($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                </div>
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
          add brand
        </button>
        
          

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>cateogory</th>
                        <th>created at</th>
                        <th>updated at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.remove wire:target="filteringData">
                    @forelse ($brands as $brand)
                    <tr>
                        <td>{{$brand->name}}</td>
                        <td>{{$brand->category->name}}</td>
                        <td>{{$brand->created_at}}</td>
                        <td>{{$brand->updated_at}}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{route('admin.brands.edit',[$brand->id])}}" class="btn btn-outline-primary btn-sm">
                                  edit
                                </a>
                                
                                <button class="btn btn-outline-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this brand?') || event.stopImmediatePropagation()"
                                wire:click="deletebrand({{$brand->id}})" wire:loading.attr="disabled">delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6">no brands</td>
                        </tr>
                    @endforelse
                </tbody>
                <tr class="loading" wire:loading wire:target="filteringData">
                    <td colspan="3">loading...</td>
                </tr>
            </table>
        </div>
        {{-- add user  --}}
        <div wire:ignore.self class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addBrandModalLabel">add brand</h5>
                  <button type="button" 
                  class="close btn btn-outline-danger btn-sm" onclick="$('#addBrandModal').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form wire:submit.prevent="addBrand" method="POST" autocomplete="off">
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
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            <input class="form-control"
                             wire:model.defer="name" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="password">category<span style="color:red">*</span></label>  
                            @error('category_id')
                            <span class="text-sm text-danger">
                                {{$message}}
                            </span>
                        @enderror
                            <select name="select" id="select" wire:model="category_id"
                            class="form-control">
                                <option value="{{null}}"></option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                              </select>
                        </div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('#addBrandModal').modal('hide')">Close</button>
                        <button type="submit" class="btn btn-primary">add</button>
                      </div>
                </form>
              </div>
            </div>
          </div>

   
          {{ $brands->links() }}
       </div>
</div>