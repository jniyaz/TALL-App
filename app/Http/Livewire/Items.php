<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $q;
    public $active;
    public $sortBy = 'id';
    public $sortAsc = true;

    // show with querystrings
    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
                ->when( $this->q, function($query) {
                    return $query->where(function($query) {
                            $query->where('title', 'like', '%' . $this->q . '%')
                                ->orWhere('price', 'like', '%' . $this->q . '%'); 
                    });
                })
                ->when( $this->active, function($query){
                    // return $q->where('status', 1); // change to local scope
                    return $query->active();
                } )
                ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $query = $items->toSql();
        $items = $items->paginate(10);
        
        return view('livewire.items', compact('items', 'query'));
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($filed)
    {
        if($filed == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $filed;
    }
}
