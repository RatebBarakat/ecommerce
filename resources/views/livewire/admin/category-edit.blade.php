<div>
    <div class="container">
        <div class="col-3 text-primary">
            <h2>
                {{$category->name}} | edit
            </h2>
        </div>
        <form action="" wire:submit.prevent="updateCategory({{$category->id}})" method="post">
            <div class="form-group">
                <label for="">name</label>@error('name')
                    {{$message}}
                @enderror
                <input class="form-control" type="text" wire:model.defer="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="">visibility</label>@error('visibility')
                    {{$message}}
                @enderror
                <input  type="checkbox" wire:model.defer="visibility">
            </div>
            <div class="form-group">
                <label for="">ads</label>@error('ads')
                    {{$message}}
                @enderror
                <input  type="checkbox" wire:model.defer="ads">
            </div>
            <div class="form-group">
                <button wire:loading.attr="disabled"
                 class="btn btn-primary" type="submit">edit</button>
            </div>
        </form>
    </div>
</div>
