<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active;

    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
                ->when($this->active, function($q){
                    // return $q->where('status', 1); // change to local scope
                    return $q->active();
                })                    
                ->paginate(10);
        return view('livewire.items', compact('items'));
    }

    public function updatingActive()
    {
        $this->resetPage();
    }
}
