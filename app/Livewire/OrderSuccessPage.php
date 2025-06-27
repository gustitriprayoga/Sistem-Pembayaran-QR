<?php
namespace App\Livewire;

use App\Models\Pesanan;
use Livewire\Component;

class OrderSuccessPage extends Component
{
    public Pesanan $pesanan;

    public function mount(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function render()
    {
        return view('livewire.order-success-page')->layout('layouts.customer-app');
    }
}
