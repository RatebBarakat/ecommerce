<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Products [{{$products->total()}}]</h6>
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
                 placeholder="search Products ..." wire:model="search" wire:input="filteringData">
            </div>
            <div class="col-sm-3 col-12 flex-end">
                <div class="form-group">per page:
                        <select name="perpage" id="perpage" wire:model="per_page" class="form-control">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                </div>
            </div>
            <div class="col-sm-3 col-12">products:
                <div class="form-group">
                    <input wire:model="with_deleted" value="off" type="radio" name="with_deleted" id="no_deleted"><label for="no_deleted">with out deleted</label> <br>
                    <input wire:model="with_deleted" value="on" type="radio" name="with_deleted" id="deleted"><label for="deleted">with deleted</label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6 col-md-3 form-group">category: <br>
                    <select class="form-control" wire:model="category_id" name="category" id="category">
                        <option value="{{null}}"></option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}} [{{$categories_count[$category->id]}}]</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3 form-group">
                    @if ($category_id != null)filter by brands: <br>
                        @foreach ($brandsFilters as $brand)
                            <input wire:model="brandsFilter" type="checkbox" name="brand" value="{{$brand->id}}" id="brand{{$brand->id}}">
                            <label for="brand{{$brand->id}}">{{$brand->name}}</label>
                        @endforeach                
                    @endif
                </div>
            </div>
        </div>
        <button  
        type="button" class="btn btn-outline-primary btn-sm mb-2"
          wire:click="showAddModal">
          add Product
        </button>
        
          

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>slug</th>
                        <th>small description</th>
                        <th>description</th>
                        <th>images[first image]</th>
                        <th>created at</th>
                        <th>updated at</th>
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.remove wir~e:target="filteringData">

                    @forelse ($products as $product)

                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->slug}}</td>
                        <td>{{$product->small_description}}</td>
                        <td>
                            @if (strlen($product->description)<250)
                                {{$product->description}}
                            @else
                                {{substr($product->description,0,250)}}
                            @endif
                        </td>
                        <td>
                            @if (count($product['images'])>0)
                            <img style="width: 70px;height:70px;margin: auto" src="{{asset('storage/'.$product->images[0])}}" alt="">
                            @endif
                        </td>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->updated_at}}</td>
                        <td>{{$product->deleted_at}}</td>
                        <td >
                                <a href="{{route('admin.users.edit',[$product->id])}}" class="btn btn-sm btn-outline-primary">
                                  edit
                                </a>
                                @if ($product->deleted_at != null)
                                <form action="" wire:submit.prevent="restoreProduct({{$product->id}})" method="post">
                                    <button type="submit" class="btn btn-outline-success btn-sm">restore</button>
                                </form>
                                @endif
                                <button class="btn btn-outline-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this Product?') || event.stopImmediatePropagation()"
                                wire:click="deleteProduct({{$product->id}})" wire:loading.attr="disabled">delete[recycle]</button>
                                <button class="btn btn-outline-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this Product?') || event.stopImmediatePropagation()"
                                wire:click="deleteProductForce({{$product->id}})" wire:loading.attr="disabled">delete totally</button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="9">no Products</td>
                        </tr>
                    @endforelse
                </tbody>
                <tr class="loading" wire:loading wire:target="filteringData">
                    <td colspan="3">loading...</td>
                </tr>
            </table>
        </div>
        {{-- add Product  --}}
        <div wire:ignore.self class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addProductModalLabel">add Product</h5>
                  <button type="button" 
                  class="close btn btn-outline-danger btn-sm" onclick="$('#addProductModal').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form wire:submit.prevent="addProduct" method="POST" autocomplete="off">
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
                            <label for="price">price:</label>
                            <input type="number" name="price" id="price" wire:model.defer="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">available quantity:</label>
                            <input type="number" name="price" id="price" wire:model.defer="available_quantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">small description<span style="color:red">*</span></label>
                            
                            <input class="form-control"
                             wire:model.defer="small_description" type="text" name="small_desc" id="small_desc">
                        </div>
                        <div class="form-group">
                            <label for="password">description<span style="color:red">*</span></label>
                                                  
                            <textarea class="form-control" wire:model.defer="description" id="description">
                            </textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" wire:model="images" multiple class="form-control my-1">
                            @if ($images)
                            Photo Preview:
                            <div class="row">
                                @foreach ($images as $image)
                                <div class="col-3 card me-1 mb-1">
                                    <img style="max-width: 100%" src="{{ $image->temporaryUrl() }}">
                                </div>
                                @endforeach
                            </div>
                        @endif
                          </div>
                        <div class="form-group">category:
                            <select name="" id="" class="form-control" wire:model="category_id">
                                <option value="{{null}}" selected></option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">brand:
                            @if ($category_id != null)
                               <select @if (is_null($category_id)) disabled @endif name="" id="" class="form-control" wire:model="brand_id">
                                <option value="{{null}}" selected></option>
                                @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>  
                            @else
                            <p class="text-info">shoose a category to show related brands</p>
                            @endif
                               
                        </div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"onclick="$('#addProductModal').modal('hide')">Close</button>
                        <button type="submit" class="btn btn-primary">add</button>
                      </div>
                </form>
              </div>
            </div>
          </div>

   
          {{ $products->links() }}
       </div>
</div>