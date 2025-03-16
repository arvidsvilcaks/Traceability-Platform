<x-app-layout>
    <h1 class="flex justify-center text-lg font-semibold mt-6">Product Overview</h1>

    {{-- Package Details --}}
    @if ($product)
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Package Details</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Quantity</th>
                        <th class="px-6 py-3 border">Package Weight</th>
                        <th class="px-6 py-3 border">Type</th>
                        <th class="px-6 py-3 border">Market</th>
                        <th class="px-6 py-3 border">Delivery Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->packagingProduct as $packaging)
                        <tr>
                            <td class="px-6 py-4 border">{{ $packaging->quantity ?? 'N/A' }}</td>
                            <td class="px-6 py-4 border">{{ $packaging->package_weight ?? 'N/A' }} kg</td>
                            <td class="px-6 py-4 border">{{ $packaging->type ?? 'N/A' }}</td>
                            <td class="px-6 py-4 border">{{ optional($packaging->market)->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 border font-bold">{{ $packaging->is_delivered ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Product Details --}}
    @if ($product)
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Product Details</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Product Name</th>
                        <th class="px-6 py-3 border">Wholesaler</th>
                        <th class="px-6 py-3 border">Packaging</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-4 border">{{ $product->name }}</td>
                        <td class="px-6 py-4 border">{{ $product->wholesaler->company ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border">{{ $product->packaging->company ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    {{-- Processes --}}
    @if ($product->processes->isNotEmpty())
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">Processes for This Product</h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Process</th>
                    <th class="px-6 py-3 border">Description</th>
                    <th class="px-6 py-3 border">Visual materials</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product->processes as $process)
                    <tr>
                        <td class="px-6 py-4 border">{{ $process->process }}</td>
                        <td class="px-6 py-4 border">{{ $process->description }}</td>
                        <td class="px-6 py-4 border">
                            @if($process->add_visual_materials)
                                <a href="{{ asset('storage/' . $process->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Quality --}}
    @if ($product->quality->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Quality Metrics for This Product</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Metric</th>
                        <th class="px-6 py-3 border">Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->quality as $quality)
                        <tr>
                            <td class="px-6 py-4 border">{{ $quality->metric }}</td>
                            <td class="px-6 py-4 border">{{ $quality->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Honeys --}}
    @if ($product->honeys->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Blended Honeys</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Honey Name</th>
                        <th class="px-6 py-3 border">Type</th>
                        <th class="px-6 py-3 border">Date of Production</th>
                        <th class="px-6 py-3 border">Apiary</th>
                        <th class="px-6 py-3 border">Beekeeper</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->honeys as $honey)
                        <tr>
                            <td class="px-6 py-4 border">{{ $honey->name }}</td>
                            <td class="px-6 py-4 border">{{ $honey->honey_type }}</td>
                            <td class="px-6 py-4 border">{{ $honey->date_of_production }}</td>
                            <td class="px-6 py-4 border">{{ $honey->apiary->location ?? 'N/A' }}</td>
                            <td class="px-6 py-4 border">{{ $honey->beekeeper->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Traceability --}}
    @if ($product->traceability->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Traceability</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Date Collected</th>
                        <th class="px-6 py-3 border">Stage</th>
                        <th class="px-6 py-3 border">Address</th>
                        <th class="px-6 py-3 border">Map</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->traceability as $trace)
                        <tr>
                            <td class="px-6 py-4 border">{{ $trace->created_at }}</td>
                            <td class="px-6 py-4 border">{{ $trace->stage }}</td>
                            <td class="px-6 py-4 border">{{ $trace->address }}</td>
                            <td class="px-6 py-4 border">
                                <div id="map-{{ $trace->id }}" class="w-full h-32 mb-4" style="height: 300px;"
                                    data-lat="{{ $trace->latitude }}" 
                                    data-lng="{{ $trace->longitude }}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script>
    function initMap() {
        document.querySelectorAll('[id^="map-"]').forEach(mapElement => {
            let lat = parseFloat(mapElement.dataset.lat);
            let lng = parseFloat(mapElement.dataset.lng);

            if (!isNaN(lat) && !isNaN(lng)) {
                let traceMap = new google.maps.Map(mapElement, {
                    center: { lat: lat, lng: lng },
                    zoom: 12
                });

                new google.maps.Marker({
                    map: traceMap,
                    position: { lat: lat, lng: lng }
                });
            }
        });
    }
    </script>
    <script async defer 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&callback=initMap">
    </script>

</x-app-layout>
