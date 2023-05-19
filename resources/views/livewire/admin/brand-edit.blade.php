<div>
    <div class="container">
        <div class="col-3 text-primary">
            <h2>
                {{$brand->name}} | edit
            </h2>
        </div>
        <form action="" wire:submit.prevent="updateBrand({{$brand->id}})" method="post">
            <div class="form-group">
                <label for="email">name<span style="color:red">*</span></label>
                @error('name')
                    <span class="text-sm text-danger">{{$message}}</span>
                @enderror

                <input class="form-control"
                 wire:model.defer="name" type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="password">category<span style="color:red">*</span></label>  
                @error('category_id')
                    <span class="text-sm text-danger">{{$message}}</span>
                @enderror
                <select name="select" id="select" wire:model="category_id"
                class="form-control">
                    <option value="{{null}}"></option>
                    @foreach ($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group">
                <button wire:loading.attr="disabled"
                 class="btn btn-primary" type="submit">edit</button>
            </div>
        </form>
    </div>
</div>
