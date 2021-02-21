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
    public $confirmingItemDeletion = false;
    public $confirmingItemAdd = false;
    public $confirmingItemEdit = false;
    public $item;

    // show with querystrings
    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'item.title' => 'required|string|min:4',
        'item.price' => 'required|numeric|between:1,100',
        'item.status' => 'boolean'
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

        // $query = $items->toSql();
        $items = $items->paginate(10);
        
        return view('livewire.items', compact('items'));
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

    public function confirmingItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        session()->flash('message', 'Item deleted successfully');
        $this->confirmingItemDeletion = false;
    }

    public function confirmingItemAdd()
    {
        $this->reset(['item']);
        $this->confirmingItemAdd = true;
    }

    public function saveItem()
    {
        $this->validate();

        if(isset($this->item->id)) {
            $this->item->save();
            session()->flash('message', 'Item saved successfully');
        } else {
            auth()->user()->items()->create([
                'title' => $this->item['title'],
                'price' => $this->item['price'],
                'status' => $this->item['status'] ?? 0,
            ]);
            session()->flash('message', 'Item Added successfully');
        }

        $this->confirmingItemAdd = false;
    }

    public function confirmingItemEdit(Item $item)
    {
        $this->item = $item;
        $this->confirmingItemAdd = true;
    }
}
