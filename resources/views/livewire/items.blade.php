<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Items
    </div>

    <div class="mt-3 text-gray-500">
        {{ $query }}
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
                            <button class="shadow bg-blue-500 px-4 py-2 text-white hover:bg-blue-400">
                                Edit
                            </button>
                            <button class="shadow bg-red-500 px-4 py-2 text-white hover:bg-red-400">
                                Delete
                            </button>
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
</div>