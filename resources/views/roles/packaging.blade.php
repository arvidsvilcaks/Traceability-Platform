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
          @foreach($processesPackaging as $processesPackaging)
          <tr>
            <td class="px-6 py-4 border">{{ $processesPackaging->process }}</td>
            <td class="px-6 py-4 border">{{ $processesPackaging->description }}</td>
            <td class="px-6 py-4 border">
                @if($processesPackaging->add_visual_materials)
                    <a href="{{ asset('storage/' . $processesPackaging->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                @endif
            </td>
            <td class="px-6 py-4 border">
              <button onclick="editModalProcess({{ json_encode($processesPackaging) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
              <form action="{{ route('processesPackaging.destroyProcess', $processesPackaging->id) }}" method="POST" style="display:inline;">
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

          <form id="addProcessForm" action="{{ route('processesPackaging.storeProcess', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="processId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="process" id="add_process" placeholder="Process" required class="border p-2 rounded">
                  <input type="text" name="description" id="add_description" placeholder="Description" required class="border p-2 rounded">
                  <input type="file" name="add_visual_materials" accept=".pdf,.docx" class="border p-2 rounded">
                  
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
          <form id="editProcessForm" action="{{ route('processesPackaging.updateProcess', ':id') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" id="edit_processId" name="id">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="process" id="add_process" placeholder="Process" required class="border p-2 rounded">
                  <input type="text" name="description" id="add_description" placeholder="Description" required class="border p-2 rounded">
                  <input type="file" name="add_visual_materials" accept=".pdf,.docx" class="border p-2 rounded">
        
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalProcess('editModalProcess')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                  </div>
              </div>
          </form>
      </div>
  </div>



  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
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
      @foreach($qualityPackaging as $qualityPackaging)
        <tr>
          <td class="px-6 py-4 border">{{ $qualityPackaging->metric }}</td>
          <td class="px-6 py-4 border">{{ $qualityPackaging->value }}</td>
          <td class="px-6 py-4 border">
            <button onclick="editModalQuality({{ json_encode($qualityPackaging) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
            
            <form action="{{ route('qualityPackaging.destroyQuality', $qualityPackaging->id) }}" method="POST" style="display:inline;">
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

          <form id="addQualityForm" action="{{ route('qualityPackaging.storeQuality', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="qualityId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="metric" id="add_metric" placeholder="Metric" required class="border p-2 rounded">
                  <input type="text" name="value" id="add_value" placeholder="Value" required class="border p-2 rounded">
                  
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
          <form id="editQualityForm" action="{{ route('qualityPackaging.updateQuality', ':id') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" id="edit_qualityId" name="id">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="metric" id="add_metric" placeholder="Metric" required class="border p-2 rounded">
                  <input type="text" name="value" id="add_value" placeholder="Value" required class="border p-2 rounded">
        
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalQuality('editModalQuality')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                  </div>
              </div>
          </form>
      </div>
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
                @foreach($traceability->filter(fn($trace) => $trace->stage === 'packaging') as $trace)
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

                <input type="hidden" name="stage" value="packaging">

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
                <button type="button" onclick="closeModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
        <h1 class="flex justify-center text-lg font-semibold mb-4">Packages</h1>
        <div class="flex justify-center mb-6">
        <button onclick="showModalPackages('addModalPackages')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
        </div>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Quantity</th>
                <th class="px-6 py-3 border">Package Weight</th>
                <th class="px-6 py-3 border">Type</th>
                <th class="px-6 py-3 border">Market</th>
                <th class="px-6 py-3 border">Package QR code</th>
                <th class="px-6 py-3 border">Actions</th>
                <th class="px-6 py-3 border">Delivery status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr>
                <td class="px-6 py-4 border">{{ $package->quantity }}</td>
                <td class="px-6 py-4 border">{{ $package->package_weight }} kg</td>
                <td class="px-6 py-4 border">{{ $package->type }}</td>
                <td class="px-6 py-4 border">{{ $package->market ? $package->market->name : 'N/A' }}</td>
                <td class="px-6 py-4 border">
                    <a href="{{ route('qr_code_Package', ['qr_code' => $package->qr_code]) }}" 
                    target="_blank" 
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">
                        View
                    </a>
                </td>
                <td class="px-6 py-4 border">
                    <button onclick="editModalPackages({{ json_encode($package) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                    
                    <form action="{{ route('packages.destroyPackage', $package->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Delete</button>
                    </form>
                </td>
                <td class="px-6 py-4 border font-bold">{{ $package->is_delivered }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div id="addModalPackages" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add packages</h2>

            <form id="addPackagesForm" action="{{ route('packages.storePackage', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="packageId" name="id">
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

                <div class="flex flex-col space-y-2">
                    <input type="number" name="quantity" id="add_quantity" placeholder="Quantity" required class="border p-2 rounded">
                    <input type="text" name="type" id="add_type" placeholder="Type" required class="border p-2 rounded">
                    <input type="number" name="package_weight" id="add_package_weight" placeholder="Package Weight (kg)" required class="border p-2 rounded">
                    <select name="is_delivered" id="add_is_delivered" class="border p-2 rounded" placeholder="Delivery status" required>
                        <option value="">Select Delivery status</option>
                        <option value="In Progress" {{ $packages->is_delivered == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Delivered" {{ $packages->is_delivered == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>

                    <select name="market_id" id="add_market_id" class="border p-2 rounded">
                        <option value="">Select Market</option>
                        @foreach($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalPackages('addModalPackages')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalPackages" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Edit packages</h2>
            <form id="editPackagesForm" action="{{ route('packages.updatePackage', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_packagesId" name="id">

                <div class="flex flex-col space-y-2">
                    <input type="number" name="quantity" id="edit_quantity" placeholder="Quantity" required class="border p-2 rounded">
                    <input type="text" name="type" id="edit_type" placeholder="Type" required class="border p-2 rounded">
                    <input type="number" name="package_weight" id="edit_package_weight" placeholder="Package Weight (kg)" required class="border p-2 rounded">
                    <select name="is_delivered" id="edit_is_delivered" placeholder="Delivery status" class="border p-2 rounded" required>
                        <option value="">Select Delivery status</option>
                        <option value="In Progress" {{ $packages->is_delivered == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Delivered" {{ $packages->is_delivered == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>

                    <select name="market_id" id="edit_market_id" class="border p-2 rounded">
                        <option value="">Select Market</option>
                        @foreach($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalPackages('editModalPackages')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
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
    
    function showModalProcess(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalProcess(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalProcess($processesPackaging) {
        document.getElementById('edit_processId').value = $processesPackaging.id;
        document.getElementById('add_process').value = $processesPackaging.processes;
        document.getElementById('add_description').value = $processesPackaging.description;

        let form = document.getElementById('editProcessForm');
        form.action = form.action.replace(':id', $processesPackaging.id);

        showModalProcess('editModalProcess');
    }

    function showModalQuality(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalQuality(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalQuality($qualityPackaging) {
        document.getElementById('edit_qualityId').value = $qualityPackaging.id;
        document.getElementById('add_metric').value = $qualityPackaging.metric;
        document.getElementById('add_value').value = $qualityPackaging.value;

        let form = document.getElementById('editQualityForm');
        form.action = form.action.replace(':id', $qualityPackaging.id);

        showModalProcess('editModalQuality');
    }

    function showModalPackages(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalPackages(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalPackages($packages) {
        document.getElementById('edit_packagesId').value = $packages.id;
        document.getElementById('edit_quantity').value = $packages.quantity;
        document.getElementById('edit_package_weight').value = $packages.package_weight;
        document.getElementById('edit_type').value = $packages.type;
        document.getElementById("edit_is_delivered").value = $packages.is_delivered;
        document.getElementById('edit_market_id').value = $packages.market_id || '';

        let form = document.getElementById('editPackagesForm');
        form.action = form.action.replace(':id', $packages.id);

        showModalPackages('editModalPackages');
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