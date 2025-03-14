<x-app-layout>
    <h1 class="flex justify-center text-lg font-semibold mt-6">Package Overview</h1>

    {{-- Product Details --}}
    @if ($package->product)
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
                        <td class="px-6 py-4 border">{{ $package->product->name }}</td>
                        <td class="px-6 py-4 border">{{ $package->product->wholesaler ? $package->product->wholesaler->company : 'N/A' }}</td>
                        <td class="px-6 py-4 border">{{ $package->product->packaging ? $package->product->packaging->company : 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    
    {{-- Processes --}}
    @if ($package->product->processes->isNotEmpty())
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">Processes for This product</h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Process</th>
                    <th class="px-6 py-3 border">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($package->product->processes as $process)
                    <tr>
                        <td class="px-6 py-4 border">{{ $process->process }}</td>
                        <td class="px-6 py-4 border">{{ $process->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Quality --}}
    @if ($package->product->quality->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Quality Metrics for This product</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Metric</th>
                        <th class="px-6 py-3 border">Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($package->product->quality as $quality)
                        <tr>
                            <td class="px-6 py-4 border">{{ $quality->metric }}</td>
                            <td class="px-6 py-4 border">{{ $quality->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Traceability --}}
    @if ($package->product->traceability->isNotEmpty() || $package->product->honeys->flatMap->traceability->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Traceability</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Date Collected</th>
                        <th class="px-6 py-3 border">Stage</th>
                        <th class="px-6 py-3 border">Address</th>
                        <th class="px-6 py-3 border">Location on map</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($package->product->honeys as $honey)
                        @foreach ($honey->traceability as $trace)
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
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script>
    let geocoder;

    function initMap() {
        geocoder = new google.maps.Geocoder();

        document.querySelectorAll('[id^="map-"]').forEach(mapElement => {
            let lat = parseFloat(mapElement.dataset.lat);
            let lng = parseFloat(mapElement.dataset.lng);

            if (!isNaN(lat) && !isNaN(lng)) {
                let traceMap = new google.maps.Map(mapElement, {
                    center: { lat: lat, lng: lng },
                    zoom: 12,
                    mapId: '37823448a8c4cd11'
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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&libraries=places&callback=initMap">
</script>

</x-app-layout>
