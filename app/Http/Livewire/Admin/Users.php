<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public int $per_page = 10;
    public $search = null;
    public $name = null;
    public $password = null;
    public $email =null;
    public $filter_by_role = null;
    public $user_id = null;
    public function resetPagination()
    {
        $this->resetPage();
    }
    public function resetInputs()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirm = null;
    }
    public function filteringData()
    {
        if (strlen($this->search) > 0) {
            $this->resetPage();
        }
    }
    public function render()
    {
        $users = User::where(function ($q)
        {
            $q->where('name','like','%'.$this->search.'%')
            ->orWhere('email','like','%'.$this->search.'%');
        })->paginate(is_int($this->per_page) ? abs($this->per_page): 10);
        return view('livewire.admin.users',compact('users'));
    }
    public function showAddModal()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetInputs();
        $this->emit('open_add_modal');
    }
    public function closeAddModal()
    {
        $this->resetInputs();
        $this->emit('close_add_modal');
    }
    public function addUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|unique:admins',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ],[
            'email.unique' => 'the name is already taken in users table or in admins table'
        ]);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'user added succesfully']);
        $this->emit('addUser');
        $this->resetErrorBag();
        $this->resetValidation();

    }
    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => $user->name.' deleted successfully'
        ]);
    }
}
