<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{
    public $user;
    public $name = null;
    public $email = null;
    public $password = null;
    public $pass_conf = null;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }
    public function render()
    {
        return view('livewire.admin.user-edit',[
            'user' => $this->user
        ]);
    }
    public function updateUser(int $id){
        $user = User::findOrFail($id);
        $this->validate([
            'name' => 'required',
            'password' => 'nullable|min:8',
            'pass_conf' => 'nullable|same:password',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $new_password = empty($this->password) ? $user->password : Hash::make($this->password);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $new_password,
        ]);
        session()->flash('edit_success','user updated successfully');
        return redirect()->route('admin.users');
    }
}
