<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    {{-- Alerts  --}}
    @if(session()->has('message'))
        <div class="bg-blue-100 p-5 w-full rounded" x-data="{show: true}" x-show="show">
            <div class="flex justify-between">
                <div class="flex space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-500 h-4 w-4">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 16.518l-4.5-4.319 1.396-1.435 3.078 2.937 6.105-6.218 1.421 1.409-7.5 7.626z" /></svg>
                    <div class="flex-1 leading-tight text-sm text-blue-700 font-medium">{{ session('message') }}</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-blue-600 h-3 w-3" @click="show=false">
                    <path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z" />
                </svg>
            </div>
        </div>
    @endif

    <div class="mt-4 mb-4 text-2xl flex justify-between">
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
    <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
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
    </x-jet-confirmation-modal>

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