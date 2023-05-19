<div>
    <div class="container">
        <div class="col-3 text-primary">
            <h2>
                {{$user->name}} | edit
            </h2>
        </div>
        <form action="" wire:submit.prevent="updateUser({{$user->id}})" method="post">
            <div class="form-group">
                <label for="">name</label>@error('name')
                    {{$message}}
                @enderror
                <input class="form-control" type="text" wire:model.defer="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="">email</label>@error('email')
                    {{$message}}
                @enderror
                <input class="form-control" type="email" wire:model.defer="email" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="">password</label>@error('password')
                    {{$message}}
                @enderror
                <input class="form-control" type="password" wire:model.defer="password" placeholder="new password">
            </div>
            <div class="form-group">
                <label for="">password confirm</label>@error('pass_conf')
                    {{$message}}
                @enderror
                <input class="form-control" type="password" wire:model.defer="pass_conf" placeholder="password confirm">
            </div>
            <div class="form-group">
                <button wire:loading.attr="disabled"
                 wire:click="$emitTo('users','edit', {{$user->name}})" class="btn btn-primary" type="submit">edit</button>
            </div>
        </form>
    </div>
</div>
