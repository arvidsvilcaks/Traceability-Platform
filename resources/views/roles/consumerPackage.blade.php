<x-app-layout>
    <h1 class="flex justify-center text-2xl font-semibold mt-6">Package Overview</h1>

    <div class="flex justify-between gap-2 mt-6">
        <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Package Details</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Package Weight</th>
                        <th class="px-6 py-3 border">Type</th>
                        <th class="px-6 py-3 border">Delivery Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-4 border">{{ $package->package_weight }} kg</td>
                        <td class="px-6 py-4 border">{{ $package->type }}</td>
                        <td class="px-6 py-4 border font-bold">{{ $package->is_delivered ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Market --}}
        @if ($package->market)
        <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Place of Sale (Market)</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Market Name</th>
                        <th class="px-6 py-3 border">Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-4 border">{{ $package->market->name }}</td>
                        <td class="px-6 py-4 border">{{ $package->market->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>



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
    <div class="flex justify-between gap-2 mt-6">
    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
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
        <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
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
    </div>


    {{-- Honey Details --}}
    @if ($package->product->honeys->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Blended honeys</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Honey Name</th>
                        <th class="px-6 py-3 border">Type</th>
                        <th class="px-6 py-3 border">Date Collected</th>
                        <th class="px-6 py-3 border">Apiary</th>
                        <th class="px-6 py-3 border">Beekeeper</th>
                        <th class="px-6 py-3 border">Laboratory</th>
                        <th class="px-6 py-3 border">Analysis results</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($package->product->honeys as $honey)
                        <tr>
                            <td class="px-6 py-4 border">{{ $honey->name }}</td>
                            <td class="px-6 py-4 border">{{ $honey->honey_type }}</td>
                            <td class="px-6 py-4 border">{{ $honey->date_of_production }}</td>
                            <td class="px-6 py-4 border">{{ $honey->apiary ? $honey->apiary->description : 'N/A' }}</td>
                            <td class="px-6 py-4 border">{{ $honey->beekeeper ? $honey->beekeeper->company : 'N/A' }}</td>
                            <td class="px-6 py-4 border">{{ $honey->laboratoryEmployee ? $honey->laboratoryEmployee->company : 'N/A' }}</td>
                            <td class="px-6 py-4 border">
                                <a href="{{ asset('storage/' . $honey->add_analysis_results) }}" 
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full" 
                                target="_blank">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Apiary --}}
    @if ($package->product->honeys->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Apiary used</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Description</th>
                        <th class="px-6 py-3 border">Location</th>
                        <th class="px-6 py-3 border">Location on Map</th>
                        <th class="px-6 py-3 border">Floral Composition</th>
                        <th class="px-6 py-3 border">Specifics of Environment</th>
                        <th class="px-6 py-3 border">Hive Count</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($package->product->honeys as $honey) 
                    @if($honey->apiary)
                        <tr>
                            <td class="px-6 py-4 border">{{ $honey->apiary->description }}</td>
                            <td class="px-6 py-4 border">{{ $honey->apiary->location }}</td>
                            <td class="px-6 py-4 border">
                                <div class="flex justify-center">
                                    <div id="map-{{ $honey->apiary->id }}" style="height: 200px; width: 300px;"
                                        data-lat="{{ $honey->apiary->latitude }}" 
                                        data-lng="{{ $honey->apiary->longitude }}">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border">{{ $honey->apiary->floral_composition }}</td>
                            <td class="px-6 py-4 border">{{ $honey->apiary->specifics_of_environment }}</td>
                            <td class="px-6 py-4 border">{{ $honey->apiary->hives_count }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Product Traceability --}}
    @if ($package->product->traceability->whereIn('stage', ['wholesaler', 'packaging'])->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Product Traceability</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Stage</th>
                        <th class="px-6 py-3 border">Produce Name</th>
                        <th class="px-6 py-3 border">Address</th>
                        <th class="px-6 py-3 border">Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($package->product->traceability->whereIn('stage', ['wholesaler', 'packaging']) as $trace)
                        <tr>
                            <td class="px-6 py-4 border font-bold uppercase">{{ $trace->stage }}</td>
                            <td class="px-6 py-4 border">{{ $trace->product?->name }}</td>
                            <td class="px-6 py-4 border">{{ $trace->address }}</td>
                            <td class="px-6 py-4 border">
                                <div class="flex justify-center">
                                    <div id="map-{{ $trace->id }}" style="height: 200px; width: 300px;"
                                        data-lat="{{ $trace->latitude }}" 
                                        data-lng="{{ $trace->longitude }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Honey Traceability --}}
    @if ($package->product->honeys->flatMap->traceability->whereIn('stage', ['beekeeper', 'laboratory'])->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Honey Traceability</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Stage</th>
                        <th class="px-6 py-3 border">Honey Name</th>
                        <th class="px-6 py-3 border">Address</th>
                        <th class="px-6 py-3 border">Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($package->product->honeys as $honey)
                        @foreach ($honey->traceability->whereIn('stage', ['beekeeper', 'laboratory']) as $trace)
                            <tr>
                                <td class="px-6 py-4 border font-bold uppercase">{{ $trace->stage }}</td>
                                <td class="px-6 py-4 border">{{ $trace->honey?->name }}</td>
                                <td class="px-6 py-4 border">{{ $trace->address }}</td>
                                <td class="px-6 py-4 border">
                                    <div class="flex justify-center">
                                        <div id="map-{{ $trace->id }}" style="height: 200px; width: 300px;"
                                            data-lat="{{ $trace->latitude }}" 
                                            data-lng="{{ $trace->longitude }}">
                                        </div>
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
