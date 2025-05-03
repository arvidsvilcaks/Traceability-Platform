<x-app-layout>
    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h3 class="text-lg font-semibold flex justify-center">Documents about Beekeeping Practices</h3>
        <div class="flex justify-center mb-6">
            <button id="showDocumentsFormButton" class="justify-center bg-gray-500 text-white px-4 py-2 rounded-full mt-4">Add New Row</button>
        </div>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Document</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beekeepingDocuments as $beekeepingDocuments)
                <tr>
                    <td class="px-6 py-4 border">
                        @if($beekeepingDocuments->add_beekeeping_documents)
                            <a href="{{ asset('storage/' . $beekeepingDocuments->add_beekeeping_documents) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                    <button onclick='showUpdateDocumentModal(@json($beekeepingDocuments))' class="bg-gray-500 text-white rounded-full px-2 py-1 mb-4">Edit</button>
                    <form action="{{ route('beekeepingDocuments.destroyDocument', $beekeepingDocuments->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-500 text-white px-2 py-1 rounded-full">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="modalBackdrop" class="fixed inset-0 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add New Document</h2>
            <form action="{{ route('beekeepingDocuments.storeDocument', ['honey_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                <input type="file" id="add_beekeeping_documents" name="add_beekeeping_documents" accept=".pdf,.docx,.jpg,.png,.jpeg" class="mb-4">
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Add</button>    
                    <button type="button" id="closeDocumentsFormButton" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editDocumentModal" class="hidden fixed inset-0 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-semibold">Edit Document</h2>
            <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editDocumentId">
                <input type="file" name="add_beekeeping_documents" id="editDocumentInput" class="border p-2 w-full" accept=".pdf,.docx,.jpg,.png,.jpeg">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Update</button>
                <button type="button" onclick="closeUpdateDocumentModal()" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h3 class="text-lg flex justify-center font-bold mb-6 mt-4">Info about Produced Honey</h3>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Date collected</th>
                    <th class="border border-gray-300 px-4 py-2">Honey Type</th>
                    <th class="border border-gray-300 px-4 py-2">Quantity (kg)</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $honeyInfo->date_of_production }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $honeyInfo->honey_type }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $honeyInfo->quantity }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full" onclick="showUpdateHoneyInfoModal({{ $honeyInfo->id }}, '{{ $honeyInfo->date_of_production }}', '{{ $honeyInfo->honey_type }}', {{ $honeyInfo->quantity }})">Add product info</button>
                    </td>
                </tr> 
            </tbody>
        </table>
    </div>

    <div id="modalBackdropHoneyInfo" class="fixed inset-0 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add New Honey Info</h2>
            <form action="{{ route('honey.storeHoneyInfo') }}" method="POST">
                @csrf
                <input type="date" name="date_of_production" class="border p-2 w-full mb-2" required>
                <input type="text" name="honey_type" placeholder="Honey Type" class="border p-2 w-full mb-2" required>
                <input type="number" name="quantity" placeholder="Quantity" class="border p-2 w-full mb-2" required>
                <div class="flex justify-end gap-2 mt-2">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Add</button>    
                    <button type="button" id="closeModalButton2" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editHoneyModal" class="hidden fixed inset-0 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-semibold">Edit Honey Info</h2>
            <form id="editHoneyForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editHoneyId" required>
                <input type="date" name="date_of_production" id="editHoneyDate" class="border p-2 w-full" required>
                <input type="text" name="honey_type" id="editHoneyType" class="border p-2 w-full" required>
                <input type="number" name="quantity" id="editHoneyQuantity" class="border p-2 w-full" required>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Update</button>
                <button type="button" onclick="closeUpdateHoneyInfoModal()" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="flex justify-between gap-6 mt-6">
        <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
            <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
                Results of honey analysis
            </h1>
            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 border">View results</th>
                    </tr>
                </thead>
                <tbody>
                    @if($honeyInfo)
                        <tr>
                            <td class="px-6 py-4 border">
                                <a href="{{ asset('storage/' . $honeyInfo->add_analysis_results) }}" 
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full" 
                                target="_blank">
                                    View
                                </a>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="px-6 py-4 border text-gray-500">
                                No analysis results available
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg w-full md:w-1/2">
            <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
                Honey QR code data
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
                            <a href="{{ route('qr_code_Honey', ['qr_code' => $honeyInfo->qr_code]) }}" 
                            target="_blank" 
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">
                                View
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mx-auto overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
            Honey Tracing
        </h1>

        @if($traceability->where('stage', 'beekeeper')->count() == 0)
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
                @foreach($traceability->filter(fn($trace) => $trace->stage === 'beekeeper') as $trace)
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

                <input type="hidden" name="stage" value="beekeeper">
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

                <input type="hidden" name="stage" value="beekeeper">
                <input type="hidden" name="latitude" id="editLatitude">
                <input type="hidden" name="longitude" id="editLongitude">

                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
                <button type="button" onclick="closeEditModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>
    
    <div class="flex justify-center mb-4">
        <button onclick="showModalLaboratory()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
            Assign Laboratory company for analysis
        </button>
    </div>
    <div class="flex justify-center mb-4">
        <p><strong>Laboratory:</strong> {{ $honeyInfo->laboratoryEmployee->company ?? 'None' }}</p>
    </div>

    <div class="flex justify-center mb-4">
        <button onclick="showModalWholesaler()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
            Assign Wholesaler company for blending
        </button>
    </div>

    <div class="flex justify-center mb-4">
        <p><strong>Wholesaler:</strong> {{ $honeyInfo->wholesaler->company ?? 'None' }}</p>
    </div>

    <div id="assignLaboratoryModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Assign Laboratory Company</h2>
            <form action="{{ route('beekeeper.assignLaboratoryAndWholesaler') }}" method="POST">
                @csrf
                <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                <label class="block mt-4">Assign Laboratory Company</label>
                <select name="laboratory_id" id="laboratorySelect" class="w-full border p-2 rounded">
                    <option value="">None</option>    
                    @foreach($laboratoryEmployees as $employee)
                        <option value="{{ $employee->id }}" {{ $honeyInfo->laboratory_id == $employee->id ? 'selected' : '' }}>
                            {{ $employee->company }}
                        </option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideModalLaboratory()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="assignWholesalerModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Assign Wholesaler Company</h2>
            <form action="{{ route('beekeeper.assignLaboratoryAndWholesaler') }}" method="POST">
                @csrf
                <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                <label class="block mt-4">Assign Wholesaler Company</label>
                <select name="wholesaler_id" id="wholesalerSelect" class="w-full border p-2 rounded">
                    <option value="">None</option>
                    @foreach($wholesalers as $wholesaler)
                        <option value="{{ $wholesaler->id }}" {{ $honeyInfo->wholesaler_id == $wholesaler->id ? 'selected' : '' }}>
                            {{ $wholesaler->company }}
                        </option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideModalWholesaler()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
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

        function showModalLaboratory() {
            document.getElementById('assignLaboratoryModal').classList.remove('hidden');
        }

        function hideModalLaboratory() {
            document.getElementById('assignLaboratoryModal').classList.add('hidden');
        }

        function showModalWholesaler() {
            document.getElementById('assignWholesalerModal').classList.remove('hidden');
        }

        function hideModalWholesaler() {
            document.getElementById('assignWholesalerModal').classList.add('hidden');
        }

        function showStoreDocumentsModal() {
            document.getElementById('modalBackdrop').classList.remove('hidden');
        }

        function closeStoreDocumentsModal() {
            document.getElementById('modalBackdrop').classList.add('hidden');
        }

        function showUpdateDocumentModal(beekeepingDocuments) {

            let docData = beekeepingDocuments;

            if (typeof docData === "string") {
                docData = JSON.parse(docData);
            }

            document.getElementById("editDocumentId").value = docData.id;
            document.getElementById("editDocumentForm").setAttribute("action", `/beekeeper/updateDocument/${docData.id}`);
            document.getElementById("editDocumentModal").classList.remove("hidden");
        }

        function closeUpdateDocumentModal() {
            document.getElementById('editDocumentModal').classList.add('hidden');
        }

        function setupModalEventListeners() {
            document.getElementById('showDocumentsFormButton').addEventListener('click', showStoreDocumentsModal);
            document.getElementById('closeDocumentsFormButton').addEventListener('click', closeStoreDocumentsModal);

            document.getElementById('modalBackdrop').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeStoreDocumentsModal();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', setupModalEventListeners);

        function showUpdateHoneyInfoModal(id, date, type, quantity) {
            document.getElementById('editHoneyId').value = id;
            document.getElementById('editHoneyDate').value = date;
            document.getElementById('editHoneyType').value = type;
            document.getElementById('editHoneyQuantity').value = quantity;
            document.getElementById('editHoneyForm').action = `/beekeeper/updateHoneyInfo/${id}`;
            document.getElementById('editHoneyModal').classList.remove('hidden');
        }
        function closeUpdateHoneyInfoModal() {
            document.getElementById('editHoneyModal').classList.add('hidden');
        }
        function showStoreHoneyInfoModal() {
            document.getElementById('modalBackdropHoneyInfo').classList.remove('hidden');
        }
        function closeStoreHoneyInfoModal() {
            document.getElementById('modalBackdropHoneyInfo').classList.add('hidden');
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
