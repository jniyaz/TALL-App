<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 mb-4 text-2xl flex justify-between">
        <div>Items</div>
        <div>
            <x-jet-button wire:click="confirmingItemAdd()">{{ __('Add Item') }}</x-jet-button>
        </div>
    </div>

    <div class="mt-3 text-gray-500">
        {{-- {{ $query }} --}}
        <div class="flex justify-between mt-2 mb-3">
            <div>
                <input wire:model="q" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" type="text" name="search" placeholder="Search" />
            </div>
            <div class="">
                <input type="checkbox" class="leadin-tight" wire:model="active" /> Active Only?
            </div>
        </div>
        <table class="table-auto w-full">
           <thead>
               <tr>
                   <th class="px-4 py-2">
                       <div class="flex items-center">
                           <button wire:click="sortBy('id')">Id</button>
                           <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">
                            <button wire:click="sortBy('title')">Title</button>
                            <x-sort-icon sortField="title" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                       </div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">
                            <button wire:click="sortBy('price')">Price</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                       </div>
                   </th>
                   @if(!$active)
                   <th class="px-4 py-2">
                       <div class="flex items-center">Status</div>
                   </th>
                   @endif
                   <th class="px-4 py-2">
                       <div class="flex justify-center">Actions</div>
                   </th>
                </tr>
           </thead>
           <tbody>
               @foreach($items as $item)
               <tr>
                   <td class="border px-4 py-2">{{ $item->id }}</td>
                   <td class="border px-4 py-2">{{ $item->title }}</td>
                   <td class="border px-4 py-2">{{ number_format($item->price, 2) }}</td>
                   @if(!$active)
                   <td class="border px-4 py-2">{{ $item->status ? 'Active' : 'Inactive' }}</td>
                   @endif
                   <td class="border px-4 py-2">
                       <div class="flex justify-center items-center space-x-2">
                            <x-jet-secondary-button wire:click="confirmingItemEdit({{ $item->id }})" wire:loading.attr="disabled">
                                {{ __('Edit') }}
                            </x-jet-secondary-button>
                            <x-jet-danger-button class="ml-2" wire:click="confirmingItemDeletion({{ $item->id }})" wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                       </div>
                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
    </div>
    <div class="mt-3">
        {{ $items->links() }}
    </div>
    
    {{-- Item Deletion Model --}}
    <x-jet-dialog-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Item Add Model --}}
    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset($this->item->id) ? 'Edit Item' : 'Add Item' }}
        </x-slot>

        <x-slot name="content">
            
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.defer="item.title" />
                <x-jet-input-error for="item.title" class="mt-2" />
            </div>
            
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="name" value="{{ __('Price') }}" />
                <x-jet-input id="price" class="block mt-1 w-full" type="text" wire:model.defer="item.price" />
                <x-jet-input-error for="item.price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" wire:model.defer="item.status" />
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>