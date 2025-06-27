<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')] // Dengar event 'cart-updated'
    public function updateCount()
    {
        $this->count = CartService::getCount();
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
