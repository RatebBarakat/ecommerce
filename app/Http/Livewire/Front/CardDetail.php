<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use Cart;
class CardDetail extends Component
{
    protected $listeners = ['cardUpdated' => 'render'];
    public function render()
    {
        $cards = Cart::getContent();
        return view('livewire.front.card-detail',compact('cards'));
    }
    public function deleteCard(int $id)
    {
        try {
            Cart::remove($id);
            $this->emit('cardUpdated');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type' => 'error',
                'message' => 'an error hapen try again'
            ]);
        }
    }
}
