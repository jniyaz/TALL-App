<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Items
    </div>

    <div class="mt-3 text-gray-500">
       <table class="table-auto w-full">
           <thead>
               <tr>
                   <th class="px-4 py-2">
                       <div class="flex items-center">Id</div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">Title</div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">Price</div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">Status</div>
                   </th>
                   <th class="px-4 py-2">
                       <div class="flex items-center">Actions</div>
                   </th>
                </tr>
           </thead>
           <tbody>
               @foreach($items as $item)
               <tr>
                   <td class="border px-4 py-2">{{ $item->id }}</td>
                   <td class="border px-4 py-2">{{ $item->title }}</td>
                   <td class="border px-4 py-2">{{ number_format($item->price, 2) }}</td>
                   <td class="border px-4 py-2">{{ $item->status ? 'Active' : 'Inactive' }}</td>
                   <td class="border px-4 py-2"></td>
               </tr>
               @endforeach
           </tbody>
       </table>
    </div>
    <div class="mt-3">
        {{ $items->links() }}
    </div>
</div>