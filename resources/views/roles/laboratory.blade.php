<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">
            Provide Honey Analysis Results
        </h1>

        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200"">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 border">Action</th>
                    <th scope="col" class="px-6 py-3 border">File</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4 border">
                        @if(isset($honeyInfo))
                            <form action="{{ route('analysis.updateAnalysis', ['id' => $honeyInfo->id]) }}" 
                                method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                @csrf
                                @method('PUT')
                                <label for="add_analysis_results" class="mb-2 text-lg">
                                    Upload Honey Analysis Results
                                </label>
                                <input type="file" name="add_analysis_results" id="add_analysis_results" 
                                    class="mb-2 border p-2" accept=".pdf,.docx">
                                <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-full">
                                    Upload
                                </button>
                            </form>
                        @else
                            <p class="text-gray-500">No product selected for analysis</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center border">
                        @if(isset($honeyInfo) && $honeyInfo->add_analysis_results)
                            <p class="text-gray-700">
                                Uploaded file: 
                                <a href="{{ asset('storage/' . $honeyInfo->add_analysis_results) }}" 
                                class="text-blue-500 underline" target="_blank">
                                    View
                                </a>
                            </p>
                            <form action="{{ route('analysis.destroyAnalysis', ['id' => $honeyInfo->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mt-2 px-4 py-2 bg-gray-500 text-white rounded-full">
                                    Remove
                                </button>
                            </form>
                        @else
                            <p class="text-gray-500">No file uploaded</p>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
            Honey Tracing
        </h1>

        <div class="flex justify-center">
            <button class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-full mb-4" onclick="showModalTraceability()">
                Add New Record
            </button>
        </div>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Date Collected</th>
                    <th class="px-6 py-3 border">Address</th>
                    <th class="px-6 py-3 border">Location on Map</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($traceability->filter(fn($trace) => $trace->stage === 'laboratory') as $trace)
                    <tr>
                        <td class="px-6 py-4 border">{{ $trace->created_at }}</td>
                        <td class="px-6 py-4 border">{{ $trace->address }}</td>

                        <td class="px-6 py-4 border">
                            <div id="map-{{ $trace->id }}" class="w-full h-32 mb-4" style="height: 300px;"
                                data-lat="{{ $trace->latitude }}" 
                                data-lng="{{ $trace->longitude }}">
                            </div>
                        </td>

                        <td class="px-6 py-4 border">
                            <button class="bg-gray-500 text-white px-3 py-1 rounded-full mb-4" onclick="showModalTraceability({{ $trace->id }})">
                                Edit
                            </button>
                            <form action="{{ route('traceability.destroyTraceabilityHoney', $trace->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white px-3 py-1 rounded-full">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div id="addModalTraceability" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Add Traceability Record</h2>
            <form action="{{ route('traceability.storeTraceabilityHoney', ['honey_id' => $honeyInfo->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                <label>Address:</label>
                <input type="text" id="address" name="address" class="border p-2 w-full mb-4" oninput="geocodeAddress()">
                <div id="map" class="w-full h-64 mb-4" style="height: 300px;"></div>

                <input type="hidden" name="stage" value="laboratory">

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
                <button type="button" onclick="closeModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>


    <script>
        
    function showModalTraceability() {
        document.getElementById('addModalTraceability').classList.remove('hidden');
    }

    function closeModalTraceability() {
        document.getElementById('addModalTraceability').classList.add('hidden');
    }
    
    let map, marker, geocoder;

    function initMap() {
        geocoder = new google.maps.Geocoder();

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 37.7749, lng: -122.4194 },
            zoom: 12,
            mapId: '37823448a8c4cd11'
        });

        marker = new google.maps.Marker({
            map: map,
            position: { lat: 37.7749, lng: -122.4194 }
        });

        document.querySelectorAll('[id^="map-"]').forEach(mapElement => {
            let traceId = mapElement.id.split('-')[1];
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

    function geocodeAddress() {
        let address = document.getElementById('address').value;
        if (!address) return;

        if (!map) { 
            console.error('Map is not initialized'); 
            return; 
        }

        geocoder.geocode({ address: address }, function (results, status) {
            if (status === 'OK') {
                let location = results[0].geometry.location;
                map.setCenter(location);
                marker.setPosition(location);
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();
            } else {
                console.error('Geocoding failed:', status);
            }
        });
    }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&libraries=places,marker&callback=initMap"></script>
</x-app-layout>
