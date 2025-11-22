<x-layouts.app :title="__('Menu')">
   <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
         <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
         </div>
         <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
         </div>
         <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
         </div>
      </div>
      <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
         <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
         order management
         lihat semua pesanan
         <table>
            <th>Id Pesanan</th>
            <th>Meja</th>
            <th>Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Waktu</th>
            <th>Aksi</th>
            <tr>
               <td>001</td>
               <td>Meja 1</td>
               <td>Nasi Goreng, Teh Manis</td>
               <td>Rp 25.000</td>
               <td>Diproses</td>
               <td>12:30 PM</td>
               <td><button class="bg-green-500 text-white px-2 py-1 rounded">Selesai</button></td>
            </tr>
            <tr>
               <td>002</td>
               <td>Meja 2</td>
               <td>Mie Ayam, Es Jeruk</td>
               <td>Rp 20.000</td>
               <td>Selesai</td>
               <td>12:45 PM</td>
               <td><button class="bg-gray-500 text-white px-2 py-1 rounded" disabled>Selesai</button></td>
            </tr>
         </table>
      </div>
   </div>
</x-layouts.app>