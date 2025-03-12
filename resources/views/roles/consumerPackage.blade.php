<x-app-layout>
    <h1 class="flex justify-center text-lg font-semibold mt-6">Package Overview</h1>
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Package Details</h1>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Quantity</th>
                    <th class="px-6 py-3 border">Package Weight</th>
                    <th class="px-6 py-3 border">Type</th>
                    <th class="px-6 py-3 border">Market</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4 border">{{ $package->quantity }}</td>
                    <td class="px-6 py-4 border">{{ $package->package_weight }} kg</td>
                    <td class="px-6 py-4 border">{{ $package->type }}</td>
                    <td class="px-6 py-4 border">{{ $package->market ? $package->market->name : 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>
