<x-app-layout>
    <div class="grid grid-cols-1 gap-4 mt-6">
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <h1 class="flex justify-center text-lg font-semibold mb-4">Description of processes</h1>
                <div class="flex justify-center mb-6">
                    <button onclick="showModalProcess('addModalProcess')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
                </div>
                <tr>
                <th class="px-6 py-3 border">Process</th>
                <th class="px-6 py-3 border">Description</th>
                <th class="px-6 py-3 border">Visual materials</th>
                <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processesWholesaler as $processesWholesaler)
                <tr>
                <td class="px-6 py-4 border">{{ $processesWholesaler->process }}</td>
                <td class="px-6 py-4 border">{{ $processesWholesaler->description }}</td>
                <td class="px-6 py-4 border">
                    @if($processesWholesaler->add_visual_materials)
                        <a href="{{ asset('storage/' . $processesWholesaler->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                    @else
                        <p>No file uploaded</p>
                    @endif
                    <div class="mt-4">
                        <form action="{{ route('processesWholesaler.destroyVisualMaterial', $processesWholesaler->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white py-1 px-2 rounded-full">Delete</button>
                        </form>   
                    </div>
                </td>
                <td class="px-6 py-4 border">
                    <button onclick="editModalProcess({{ json_encode($processesWholesaler) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                    <form action="{{ route('processesWholesaler.destroyProcess', $processesWholesaler->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white py-1 px-2 rounded-full">Delete</button>
                    </form>            
                </td>          
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <div id="addModalProcess" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add Process</h2>

            <form id="addProcessForm" action="{{ route('processesWholesaler.storeProcess', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="processId" name="id">
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="process" id="add_process" placeholder="Process" required class="border p-2 rounded">
                    <input type="text" name="description" id="add_description" placeholder="Description" required class="border p-2 rounded">
                    <input type="file" name="add_visual_materials" accept=".pdf,.docx,.jpg,.png,.jpeg" class="border p-2 rounded">
                    
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalProcess('addModalProcess')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalProcess" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Edit Process</h2>
            <form id="editProcessForm" action="{{ route('processesWholesaler.updateProcess', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_processId" name="id">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="process" id="add_process" placeholder="Process" class="border p-2 rounded" required>
                    <input type="text" name="description" id="add_description" placeholder="Description" class="border p-2 rounded" required>
                    <input type="file" name="add_visual_materials" accept=".pdf,.docx,.jpg,.png,.jpeg" class="border p-2 rounded">
        
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalProcess('editModalProcess')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Honey quality</h1>
            <div class="flex justify-center mb-6">
            <button onclick="showModalQuality('addModalQuality')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
            </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Quality Assessment (Metric)</th>
                <th class="px-6 py-3 border">Value</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($qualityWholesaler as $qualityWholesaler)
            <tr>
                <td class="px-6 py-4 border">{{ $qualityWholesaler->metric }}</td>
                <td class="px-6 py-4 border">{{ $qualityWholesaler->value }}</td>
                <td class="px-6 py-4 border">
                <button onclick="editModalQuality({{ json_encode($qualityWholesaler) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                
                <form action="{{ route('qualityWholesaler.destroyQuality', $qualityWholesaler->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div id="addModalQuality" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add Quality Standard</h2>

            <form id="addQualityForm" action="{{ route('qualityWholesaler.storeQuality', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="qualityId" name="id">
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="metric" id="add_metric" placeholder="Quality metric" required class="border p-2 rounded">
                    <input type="text" name="value" id="add_value" placeholder="Description" required class="border p-2 rounded">
                    
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalQuality('addModalQuality')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalQuality" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Edit Quality Standard</h2>
            <form id="editQualityForm" action="{{ route('qualityWholesaler.updateQuality', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_qualityId" name="id">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="metric" id="add_metric" placeholder="Quality metric" class="border p-2 rounded" required>
                    <input type="text" name="value" id="add_value" placeholder="Value" class="border p-2 rounded" required>
        
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalQuality('editModalQuality')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6 bg-gray-100">
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Information about selling further for packaging</h1>
            <div class="flex justify-center mb-6">
            <button onclick="showModalMarket('addModalMarket')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
            </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Market Name</th>
                <th class="px-6 py-3 border">Address</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($market as $market)
            <tr>
                <td class="px-6 py-4 border">{{ $market->name }}</td>
                <td class="px-6 py-4 border">{{ $market->address }}</td>
                <td class="px-6 py-4 border">
                <button onclick="editModalMarket({{ json_encode($market) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                <form action="{{ route('market.destroyMarket', $market->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div id="addModalMarket" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add Market</h2>
            <form id="addMarketForm" action="{{ route('market.storeMarket', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="marketId" name="id">
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="name" id="add_name" placeholder="Market name" required class="border p-2 rounded">
                    <input type="text" name="address" id="add_address" placeholder="Address" required class="border p-2 rounded">
                    
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalMarket('addModalMarket')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalMarket" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Edit Market</h2>
            <form id="editMarketForm" action="{{ route('market.updateMarket', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_marketId" name="id">

                <div class="flex flex-col space-y-2">
                    <input type="text" name="name" id="add_name" placeholder="Market name" class="border p-2 rounded" required>
                    <input type="text" name="address" id="add_address" placeholder="Address" class="border p-2 rounded" required>
        
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalMarket('editModalMarket')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
            Product QR code data
        </h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">QR Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4">
                        <a href="{{ route('qr_code_Product', ['qr_code' => $honeyInfo->qr_code]) }}" 
                        target="_blank" 
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">
                            View
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
            Product Tracing
        </h1>

        @if($traceability->where('stage', 'wholesaler')->count() == 0)
            <div class="flex justify-center">
                <button class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-full mb-4" onclick="showModalTraceability()">
                    Add New Record
                </button>
            </div>
        @endif
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Date Shipped</th>
                    <th class="px-6 py-3 border">Address</th>
                    <th class="px-6 py-3 border">Shipped from (Location)</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($traceability->filter(fn($trace) => $trace->stage === 'wholesaler') as $trace)
                    <tr>
                        <td class="px-6 py-4 border">{{ $trace->created_at }}</td>
                        <td class="px-6 py-4 border">{{ $trace->address }}</td>

                        <td class="px-6 py-4 border">
                            <div class="flex justify-center">
                                <div id="map-{{ $trace->id }}" style="height: 300px; width: 300px;"
                                    data-lat="{{ $trace->latitude }}" 
                                    data-lng="{{ $trace->longitude }}">
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 border">
                            <button class="bg-gray-500 text-white px-3 py-1 rounded-full mb-4" onclick="showEditModalTraceability({{ $trace->id }})">
                                Edit
                            </button>
                            <form action="{{ route('traceability.destroyTraceabilityProduct', $trace->id) }}" method="POST" class="inline">
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
            <form action="{{ route('traceability.storeTraceabilityProduct', ['product_id' => $honeyInfo->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <label>Address:</label>
                <input type="text" id="address" name="address" class="border p-2 w-full mb-4" oninput="geocodeAddress()">
                <div id="map" class="w-full h-64 mb-4" style="height: 300px;"></div>

                <input type="hidden" name="stage" value="wholesaler">

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
                <button type="button" onclick="closeModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModalTraceability" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Edit Traceability Record</h2>
            <form action="{{ route('traceability.updateTraceabilityHoney', ':id') }}" method="POST" id="editTraceabilityForm">
                @csrf
                @method('PUT')
                
                <label>Address:</label>
                <input type="text" id="editAddress" name="address" class="border p-2 w-full mb-4" oninput="geocodeEditAddress()">
                <div id="editMap" class="w-full h-64 mb-4" style="height: 300px;"></div>

                <input type="hidden" name="stage" value="wholesaler">
                <input type="hidden" name="latitude" id="editLatitude">
                <input type="hidden" name="longitude" id="editLongitude">

                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
                <button type="button" onclick="closeEditModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="flex justify-center mb-4 mt-6">
        <button onclick="showModalPackaging()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
            Assign Packaging company for blending
        </button>
    </div>

    <div class="flex justify-center mb-4">
        <p><strong>Packaging:</strong> {{ $honeyInfo->packaging->company ?? 'None' }}</p>
    </div>

    <div id="assignPackagingModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Assign Packaging Company</h2>
            <form action="{{ route('wholesaler.assignPackaging') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <label class="block mt-4">Assign Packaging Company</label>
                <select name="packaging_id" id="packagingSelect" class="w-full border p-2 rounded">
                    <option value="">None</option>
                    @foreach($packaging as $packaging)
                        <option value="{{ $packaging->id }}" {{ $honeyInfo->packaging_id == $packaging->id ? 'selected' : '' }}>
                            {{ $packaging->company }}
                        </option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideModalPackaging()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
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

    function showEditModalTraceability(id) {
        const traceability = @json($traceability);
        const trace = traceability.find(item => item.id === id);

        if (trace) {
            document.getElementById('editModalTraceability').classList.remove('hidden');
            document.getElementById('editTraceabilityForm').action = `/traceabilityHoney/${id}`;
            document.getElementById('editAddress').value = trace.address;
            document.getElementById('editLatitude').value = trace.latitude;
            document.getElementById('editLongitude').value = trace.longitude;

            editMap = new google.maps.Map(document.getElementById('editMap'), {
                center: { lat: parseFloat(trace.latitude), lng: parseFloat(trace.longitude) },
                zoom: 12,
                mapId: '37823448a8c4cd11'
            });

            editMarker = new google.maps.Marker({
                map: editMap,
                position: { lat: parseFloat(trace.latitude), lng: parseFloat(trace.longitude) },
            });

            google.maps.event.addListener(editMarker, function (event) {
                document.getElementById('editLatitude').value = event.latLng.lat();
                document.getElementById('editLongitude').value = event.latLng.lng();
            });
        }
    }

    function closeEditModalTraceability() {
        document.getElementById('editModalTraceability').classList.add('hidden');
    }

    function showModalPackaging() {
        document.getElementById('assignPackagingModal').classList.remove('hidden');
    }

    function hideModalPackaging() {
        document.getElementById('assignPackagingModal').classList.add('hidden');
    }

    function showModalProcess(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalProcess(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalProcess($processesWholesaler) {
        document.getElementById('edit_processId').value = $processesWholesaler.id;
        document.getElementById('add_process').value = $processesWholesaler.process;
        document.getElementById('add_description').value = $processesWholesaler.description;

        let form = document.getElementById('editProcessForm');
        form.action = form.action.replace(':id', $processesWholesaler.id);

        showModalProcess('editModalProcess');
    }

    function showModalQuality(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalQuality(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalQuality($qualityWholesaler) {
        document.getElementById('edit_qualityId').value = $qualityWholesaler.id;
        document.getElementById('add_metric').value = $qualityWholesaler.metric;
        document.getElementById('add_value').value = $qualityWholesaler.value;

        let form = document.getElementById('editQualityForm');
        form.action = form.action.replace(':id', $qualityWholesaler.id);

        showModalProcess('editModalQuality');
    }

    function showModalMarket(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalMarket(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalMarket($market) {
        document.getElementById('edit_marketId').value = $market.id;
        document.getElementById('add_name').value = $market.name;
        document.getElementById('add_address').value = $market.address;

        let form = document.getElementById('editMarketForm');
        form.action = form.action.replace(':id', $market.id);

        showModalProcess('editModalMarket');
    }

    let map, marker, geocoder;

    function initMap() {
        geocoder = new google.maps.Geocoder();

        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 56.94965, lng: 24.10518 },
            zoom: 12,
            mapId: '37823448a8c4cd11'
        });

        marker = new google.maps.Marker({
            map: map,
            position: { lat: 56.94965, lng: 24.10518 }
        });

        editMap = new google.maps.Map(document.getElementById('editMap'), {
            center: { lat: 56.94965, lng: 24.10518 },
            zoom: 12,
            mapId: '37823448a8c4cd11'
        });

        editMarker = new google.maps.Marker({
            map: editMap,
            position: { lat: 56.94965, lng: 24.10518 }
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

    function geocodeEditAddress() {
        let address = document.getElementById('editAddress').value;
        if (!address) return;

        geocoder.geocode({ address: address }, function (results, status) {
            if (status === 'OK') {
                let location = results[0].geometry.location;
                
                editMap.setCenter(location);
                editMarker.setPosition(location);

                document.getElementById('editLatitude').value = location.lat();
                document.getElementById('editLongitude').value = location.lng();
            } else {
                console.error('Geocoding failed:', status);
            }
        });
    }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&libraries=places,marker&callback=initMap"></script>
</x-app-layout>
