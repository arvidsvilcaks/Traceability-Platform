<x-app-layout>
    <h1 class="flex justify-center text-lg font-semibold mt-6">Package Overview</h1>

    {{-- Honey Details --}}
    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">Honey Details</h1>
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
                <tr>
                    <td class="px-6 py-4 border">{{ $honey->name }}</td>
                    <td class="px-6 py-4 border">{{ $honey->honey_type }}</td>
                    <td class="px-6 py-4 border">{{ $honey->date_of_production }}</td>
                    <td class="px-6 py-4 border">{{ $honey->apiary ? $honey->apiary->location : 'N/A' }}</td>
                    <td class="px-6 py-4 border">{{ $honey->beekeeper ? $honey->beekeeper->name : 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Apiary Details --}}
    @if ($honey->apiary)
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Apiary Information</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Description</th>
                        <th class="px-6 py-3 border">Location</th>
                        <th class="px-6 py-3 border">Floral Composition</th>
                        <th class="px-6 py-3 border">Specifics of Environment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-4 border">{{ $honey->apiary->description }}</td>
                        <td class="px-6 py-4 border">{{ $honey->apiary->location }}</td>
                        <td class="px-6 py-4 border">{{ $honey->apiary->floral_composition }}</td>
                        <td class="px-6 py-4 border">{{ $honey->apiary->specifics_of_environment }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    {{-- Beekeeping Documents --}}
    @if ($beekeepingDocuments->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Beekeeping Documents</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beekeepingDocuments as $document)
                        <tr>
                            <td class="px-6 py-4 border">{{ $document->add_beekeeping_documents }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Traceability --}}
    @if ($honey->traceability->isNotEmpty())
        <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Traceability</h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Date Collected</th>
                        <th class="px-6 py-3 border">Stage</th>
                        <th class="px-6 py-3 border">Address</th>
                        <th class="px-6 py-3 border">Location on Map</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($honey->traceability as $trace)
                        <tr>
                            <td class="px-6 py-4 border">{{ $trace->created_at }}</td>
                            <td class="px-6 py-4 border">{{ $trace->stage }}</td>
                            <td class="px-6 py-4 border">{{ $trace->address }}</td>
                            <td class="px-6 py-4 border">
                                <div id="map-{{ $trace->id }}" class="w-full h-32 mb-4" 
                                    style="height: 300px;" 
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
