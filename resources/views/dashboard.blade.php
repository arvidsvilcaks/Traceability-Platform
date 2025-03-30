<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Traceability platform') }}
        </h2>
    </x-slot>

    @if(auth()->user()->role != 'Beekeeping association' && auth()->user()->role != 'Administrator')

    <!-- Apiary List -->
    @if(auth()->user()->role == 'Beekeeper')
    
    <div class="container mx-auto mt-6 mb-6 overflow-x-auto">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-4">Apiary List</h1>

            <div class="flex justify-center mb-4">
                <button onclick="showStoreApiaryModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                    Add New Apiary
                </button>
            </div>

            <table class="w-full text-sm text-center text-gray-500 border-separate border-2 border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Description</th>
                        <th class="px-6 py-3 border">Location</th>
                        <th class="px-6 py-3 border">Map</th>
                        <th class="px-6 py-3 border">Floral Composition</th>
                        <th class="px-6 py-3 border">Specifics of Environment</th>
                        <th class="px-6 py-3 border">Hive Count</th>
                        <th class="px-6 py-3 border">Visual Materials</th>
                        @if(auth()->user()->role == 'Beekeeper')
                            <th class="px-6 py-3 border">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($apiaryInfo as $apiary)
                    <tr>
                        <td class="px-6 py-4 border">{{ $apiary->description }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->location }}</td>
                        <td class="px-6 py-4 border">
                            <div id="map-{{ $apiary->id }}" class="w-full h-32 mb-4" style="height: 300px; width: 200px;"
                                data-lat="{{ $apiary->latitude }}" 
                                data-lng="{{ $apiary->longitude }}">
                            </div>
                        </td>
                        <td class="px-6 py-4 border">{{ $apiary->floral_composition }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->specifics_of_environment }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->hives_count }}</td>
                        <td class="px-6 py-4 border">
                            <div class="mt-2">
                                @if($apiary->add_visual_materials)
                                    <a href="{{ asset('storage/' . $apiary->add_visual_materials) }}" target="_blank" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 ">View</a>
                                @else
                                    <span class="text-gray-500">No file uploaded</span>
                                @endif
                                <div class="mt-4">
                                    <form action="{{ route('dashboard.destroyVisualMaterial', $apiary->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white py-1 px-2 rounded-full">
                                            Delete
                                        </button>
                                    </form>                                    
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 border ">
                            @if(auth()->user()->role == 'Beekeeper' && $apiary->beekeeper_id == auth()->user()->id)
                                <button onclick="showUpdateApiaryModal({{ $apiary->id }}, '{{ $apiary->description }}', '{{ $apiary->location }}', '{{ $apiary->floral_composition }}', '{{ $apiary->specifics_of_environment }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.destroyApiary', $apiary->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-2">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div id="addApiaryModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="modal-container bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Add New Apiary</h2>
                <form action="{{ route('dashboard.storeApiary') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2">Description:</label>
                    <input type="text" name="description" required class="w-full border p-2 rounded">    
                    <label class="block mb-2 mt-4">Location:</label>
                    <input type="text" id="location" name="location" required class="w-full border p-2 rounded" oninput="geocodeAddress()">
                    <div id="map" class="w-full h-64 mb-4" style="height: 300px;"></div>
                    <label class="block mb-2 mt-4">Floral Composition:</label>
                    <input type="text" name="floral_composition" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Specifics of Environment:</label>
                    <input type="text" name="specifics_of_environment" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Hive Count:</label>
                    <input type="number" name="hives_count" required class="w-full border p-2 rounded">                    
                    <label class="block mb-2 mt-4">Add Visual Materials:</label>
                    <input type="file" name="add_visual_materials" class="w-full border p-2 rounded">
                    <input type="hidden" name="beekeeper_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div class="mt-4 flex justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                        <button type="button" onclick="hideStoreApiaryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="editApiaryModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="modal-container bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Edit Apiary</h2>
                <form id="editApiaryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editApiaryId" name="id">
                    <label class="block mb-2">Description:</label>
                    <input type="text" id="editApiaryDescription" name="description" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Location:</label>
                    <input type="text" id="editApiaryLocation" name="location" required class="w-full border p-2 rounded" oninput="geocodeEditAddress()">
                    <div id="editMap" class="w-full h-64 mb-4" style="height: 300px;"></div>
                    <label class="block mb-2 mt-4">Floral Composition:</label>
                    <input type="text" id="editApiaryFloralComposition" name="floral_composition" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Specifics of Environment:</label>
                    <input type="text" id="editApiarySpecificsOfEnvironment" name="specifics_of_environment" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Hive Count:</label>
                    <input type="number" id="editApiaryHivesCount" name="hives_count" required class="w-full border p-2 rounded">        
                    <label class="block mb-2 mt-4">Add Visual Materials:</label>
                    <input type="file" name="add_visual_materials" class="w-full border p-2 rounded">
                    <input type="hidden" name="latitude" id="editLatitude">
                    <input type="hidden" name="longitude" id="editLongitude">
                    <div class="mt-4 flex justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                        <button type="button" onclick="hideUpdateApiaryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    @endif

    @if(auth()->user()->role != 'Packaging company')

    <!-- Honey List -->
    <div class="container mx-auto overflow-x-auto mb-4">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-4">Honey List</h1>

        @if(auth()->user()->role == 'Beekeeper')
            <div class="flex justify-center mb-4">
                <button onclick="showStoreHoneyModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                    Add New Honey
                </button>
            </div>
        @endif

        <table class="w-full text-sm text-center text-gray-500 border-separate border-2 border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Name</th>
                    <th class="px-6 py-3 border">Apiary</th>
                    @if(auth()->user()->role == 'Beekeeper' || auth()->user()->role == 'Laboratory employee')
                        <th class="px-6 py-3 border">Action</th>
                    @elseif(auth()->user()->role == 'Wholesaler')
                        <th class="px-6 py-3 border">Beekeeper (Producer)</th>
                        <th class="px-6 py-3 border">Quantity (kg)</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($honeyInfo as $honey)
                <tr>
                    <td class="px-6 py-4 border">{{ $honey->name }}</td>
                    <td class="px-6 py-4 border">{{ $honey->apiary->description ?? 'No Apiary Assigned' }}</td>
                    <td class="px-6 py-4 border">
                        @if(auth()->user()->role == 'Beekeeper' && $honey->beekeeper_id == auth()->user()->id)

                            <div>
                                <a href="{{ route('beekeeper.index', ['honey_id' => $honey->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View
                                </a>
                                <button onclick="showUpdateHoneyModal({{ $honey->id }}, '{{ $honey->name }}', '{{ $honey->apiary_id }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 ml-1 mt-2">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.destroyHoney', $honey->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-2">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @elseif(auth()->user()->role == 'Laboratory employee' && $honey->laboratory_id == auth()->user()->id)
                            <a href="{{ route('laboratory.index', ['honey_id' => $honey->id]) }}" 
                            class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                View
                            </a>
                        @elseif(auth()->user()->role == 'Wholesaler' && $honey->wholesaler_id == auth()->user()->id)
                            <p>{{ $honey->beekeeper->company ?? 'Unknown' }}</p>
                        @endif
                    </td>
                    @if(auth()->user()->role == 'Wholesaler' && $honey->wholesaler_id == auth()->user()->id)
                    <td class="px-6 py-4 border">
                            <p>{{ $honey->quantity }}</p>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @endif

    @if(auth()->user()->role == 'Beekeeper')
    <div id="addHoneyModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Add New Honey</h2>
            <form action="{{ route('dashboard.storeHoney') }}" method="POST">
                @csrf
                <label class="block mb-2">Honey Name:</label>
                <input type="text" name="name" required class="w-full border p-2 rounded">    

                <label class="block mb-2 mt-4">Select Apiary:</label>
                <select name="apiary_id" required class="w-full border p-2 rounded">
                    <option value="">Select an Apiary</option>
                    @foreach($apiaryInfo as $apiary)
                        <option value="{{ $apiary->id }}">{{ $apiary->description }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="beekeeper_id" value="{{ auth()->user()->id }}">

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideStoreHoneyModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editHoneyModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Honey</h2>
            <form id="editHoneyForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editHoneyId" name="id">
                
                <label class="block mb-2">Honey Name:</label>
                <input type="text" id="editHoneyName" name="name" required class="w-full border p-2 rounded">

                <label class="block mb-2 mt-4">Select Apiary:</label>
                <select id="editApiarySelect" name="apiary_id" required class="w-full border p-2 rounded">
                    <option value="">Select an Apiary</option>
                    @foreach($apiaryInfo as $apiary)
                        <option value="{{ $apiary->id }}">{{ $apiary->description }}</option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideUpdateHoneyModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @endif




    @if(auth()->user()->role == 'Wholesaler' || auth()->user()->role == 'Packaging company')

    <!-- Product List -->
    <div class="container mx-auto overflow-x-auto">
        <h3 class="flex justify-center text-lg font-semibold mb-4 mt-4">Products List</h3>
        @if(auth()->user()->role == 'Wholesaler')

        <div class="flex justify-center mt-4 mb-4">
            <button onclick="showStoreProductModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                Add New Product
            </button>
        </div>
        @endif
        <table class="w-full text-sm text-center text-gray-500 border-separate border-2 border-gray mb-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Name</th>
                    <th class="px-6 py-3 border">Bleneded Honey's</th>
                    <th class="px-6 py-3 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $products)
                    <tr class="border-t">
                        <td class="px-6 py-4 border">{{ $products->name }}</td>
                        <td class="px-6 py-4 border">
                            @foreach($products->honeys as $honey)
                                {{ $honey->name }}<br>
                            @endforeach
                        </td>

                        @if(auth()->user()->role == 'Wholesaler' && $products->wholesaler_id == auth()->user()->id)

                        <td class="px-6 py-4 border">
                            <div>
                                    <a href="{{ route('wholesaler.index', ['product_id' => $products->id]) }}" 
                                    class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                        View
                                    </a>
                                <button onclick="showUpdateProductModal({{ $products->id }}, '{{ $products->name }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-3 ml-1">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.product.destroyProduct', $products->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-1">
                                    Delete
                                </button>
                                </form>
                            </div>
                        </td>

                        @elseif(auth()->user()->role == 'Packaging company' && $products->packaging_id == auth()->user()->id)
                        <td class="px-6 py-4 border">
                            <div>
                                <a href="{{ route('packaging.index', ['product_id' => $products->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View
                                </a>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div id="productModal" class="modal fixed inset-0 flex items-center justify-center hidden">
            <div class="modal-dialog bg-white rounded-lg shadow-lg w-full max-w-lg">
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold" id="productModalLabel">Manage Products</h5>
                    <button type="button" onclick="hideStoreProductModal()" class="text-black font-bold text-2xl">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('dashboard.product.storeProduct') }}" method="POST">
                        @csrf
                        <input type="hidden" name="wholesaler_id" value="{{ auth()->user()->id }}">

                        <div class="form-group mb-4">
                            <label for="name" class="block text-gray-700">Product Name:</label>
                            <input type="text" name="name" class="form-control w-full p-2 border border-gray-300 rounded-md" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="block text-gray-700">Available Honey's:</label>
                            <div class="space-y-2">
                                @foreach($honeyInfo as $honey)
                                    @if($honey->is_available)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="honey_ids[]" value="{{ $honey->id }}" id="honey_{{ $honey->id }}" class="form-checkbox text-gray-600">
                                            <label for="honey_{{ $honey->id }}" class="text-gray-800">{{ $honey->name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-700">Create Product</button>
                    </form>
                </div>
            </div>
        </div>


        <div id="editProductModal" class="fixed inset-0 flex justify-center items-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold mb-4">Edit Product</h3>
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editProductId" name="id">

                    <div class="mb-4">
                        <label for="editProductName" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="editProductName" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-700">Save Changes</button>
                        <button type="button" onclick="hideUpdateProductModal()" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endif

    <script>

    function showStoreApiaryModal() {
        document.getElementById('addApiaryModal').classList.remove('hidden');
    }

    function hideStoreApiaryModal() {
        document.getElementById('addApiaryModal').classList.add('hidden');
    }

    function showUpdateApiaryModal(id, description, location, floral_composition, specifics_of_environment, longitude, latitude, hives_count) {
    const traceability = @json($apiaryInfo);
    const trace = traceability.find(item => item.id == id);
    if (trace) {
        document.getElementById('editApiaryModal').classList.remove('hidden');
        document.getElementById('editApiaryForm').action = '/dashboard/updateApiary/' + id;
        document.getElementById('editApiaryDescription').value = description;
        document.getElementById('editApiaryLocation').value = location;
        document.getElementById('editLatitude').value = trace ? trace.latitude : latitude;
        document.getElementById('editLongitude').value = trace ? trace.longitude : longitude;
        document.getElementById('editApiaryFloralComposition').value = floral_composition;
        document.getElementById('editApiarySpecificsOfEnvironment').value = specifics_of_environment;
        document.getElementById('editApiaryHivesCount').value = trace ? trace.hives_count : hives_count;

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

    function hideUpdateApiaryModal() {
        document.getElementById('editApiaryModal').classList.add('hidden');
    }

    function showStoreHoneyModal() {
        document.getElementById('addHoneyModal').classList.remove('hidden');
    }

    function hideStoreHoneyModal() {
        document.getElementById('addHoneyModal').classList.add('hidden');
    }
    function showUpdateHoneyModal(id, name, apiary_id) {
        document.getElementById('editHoneyId').value = id;
        document.getElementById('editHoneyName').value = name;
        document.getElementById('editApiarySelect').value = apiary_id;
        document.getElementById('editHoneyForm').action = '/dashboard/updateHoney/' + id;

        document.getElementById('editHoneyModal').classList.remove('hidden');
    }

    function hideUpdateHoneyModal() {
        document.getElementById('editHoneyModal').classList.add('hidden');
    }

    function showStoreProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.remove('hidden');
    }

    function hideStoreProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
    }

    function showUpdateProductModal(id, name) {
        document.getElementById('editProductModal').classList.remove('hidden');
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editProductForm').action = '/dashboard/product/updateProduct/' + id;
    }

    function hideUpdateProductModal() {
        document.getElementById('editProductModal').classList.add('hidden');
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
        let location = document.getElementById('location').value;
        if (!location) return;

        geocoder.geocode({ address: location }, function (results, status) {
            if (status === 'OK') {
                let geoLocation = results[0].geometry.location; 
                map.setCenter(geoLocation);
                marker.setPosition(geoLocation);
                document.getElementById('latitude').value = geoLocation.lat();
                document.getElementById('longitude').value = geoLocation.lng();
            } else {
                console.error('Geocoding failed:', status);
            }
        });
    }


    function geocodeEditAddress() {
        let location = document.getElementById('editApiaryLocation').value;
        if (!location) return;

        geocoder.geocode({ address: location }, function (results, status) { 
            if (status === 'OK') {
                let geoLocation = results[0].geometry.location;
                console.log('Geocode results:', results);

                editMap.setCenter(geoLocation);
                editMarker.setPosition(geoLocation);

                document.getElementById('editLatitude').value = geoLocation.lat();
                document.getElementById('editLongitude').value = geoLocation.lng();
            } else {
                console.error('Geocoding failed:', status);
            }
        });
    }



</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&libraries=places,marker&callback=initMap"></script>

<style>
.modal-container {
    max-height: 90vh;
    overflow-y: auto;
    width: 90%;
    max-width: 450px; 
}
</style>
</x-app-layout>