<x-app-layout>
    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">Info about apiary</h1>
        
        <div class="flex justify-center mb-6">
            <button onclick="showModal3('addModal')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
        </div>

        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Apiary description</th>
                    <th class="px-6 py-3 border">Location</th>
                    <th class="px-6 py-3 border">Floral composition</th>
                    <th class="px-6 py-3 border">Specifics of environment</th>
                    <th class="px-6 py-3 border">Visual materials</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apiary as $apiary)
                    <tr>
                        <td class="px-6 py-4 border">{{ $apiary->description }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->location }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->floral_composition }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->specifics_of_environment }}</td>
                        <td class="px-6 py-4 border">
                            @if($apiary->add_visual_materials)
                                <a href="{{ asset('storage/' . $apiary->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 border">
                            <button onclick="editModal({{ json_encode($apiary) }})" class="bg-gray-500 text-white rounded-full px-4 py-2">Edit</button>
                            <form action="{{ route('apiary.destroyApiary', $apiary->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="addModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Add Apiary</h2>

                <form id="addApiaryForm" action="{{ route('apiary.storeApiary', ['honey_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="apiaryId" name="id">
                    <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                    <div class="flex flex-col space-y-2">
                        <input type="text" name="description" id="add_description" placeholder="Description" required class="border p-2 rounded">
                        <input type="text" name="location" id="add_location" placeholder="Location" required class="border p-2 rounded">
                        <input type="text" name="floral_composition" id="add_floral_composition" placeholder="Floral Composition" required class="border p-2 rounded">
                        <input type="text" name="specifics_of_environment" id="add_specifics_of_environment" placeholder="Environment Specifics" required class="border p-2 rounded">
                        <input type="file" name="add_visual_materials" accept=".pdf,.docx" class="border p-2 rounded">
                        
                        <div class="flex justify-between mt-4">
                            <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                            <button type="button" onclick="closeModal3('addModal')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Edit Apiary</h2>
                <form id="editApiaryForm" action="{{ route('apiary.updateApiary', ':id') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_apiaryId" name="id">

                    <div class="flex flex-col space-y-2">
                        <input type="text" name="description" id="edit_description" placeholder="Description" class="border p-2 rounded">
                        <input type="text" name="location" id="edit_location" placeholder="Location" class="border p-2 rounded">
                        <input type="text" name="floral_composition" id="edit_floral_composition" placeholder="Floral Composition" class="border p-2 rounded">
                        <input type="text" name="specifics_of_environment" id="edit_specifics_of_environment" placeholder="Environment Specifics" class="border p-2 rounded">
                        <input type="file" name="add_visual_materials" accept=".pdf,.docx" class="border p-2 rounded">

                        <div class="flex justify-between mt-4">
                            <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                            <button type="button" onclick="closeModal4('editModal')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h3 class="text-lg font-semibold flex justify-center">Documents about Beekeeping Practices</h3>
        <div class="flex justify-center mb-6">
            <button id="showFormButton" class="justify-center bg-gray-500 text-white px-4 py-2 rounded-full mt-4">Add New Row</button>
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
                    <button onclick='editDocument(@json($beekeepingDocuments))' class="bg-gray-500 text-white rounded-full px-2 py-1 mb-4">Edit</button>
                    <form action="{{ route('beekeepingDocuments.deleteDocument', $beekeepingDocuments->id) }}" method="POST" class="inline">
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

    <div id="modalBackdrop" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add New Document</h2>
            <form action="{{ route('beekeepingDocuments.addDocument', ['honey_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="honey_id" value="{{ $honeyInfo->id }}">

                <input type="file" id="add_beekeeping_documents" name="add_beekeeping_documents" accept=".pdf,.docx" class="mb-4">
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Add</button>    
                    <button type="button" id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editDocumentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-semibold">Edit Document</h2>
            <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editDocumentId">
                <input type="file" name="add_beekeeping_documents" id="editDocumentInput" class="border p-2 w-full" accept=".pdf,.docx">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Update</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
        <h3 class="text-lg font-semibold flex justify-center mb-6 mt-4">Info about Produced Honey</h3>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Date</th>
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
                        <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full" onclick="editHoney({{ $honeyInfo->id }}, '{{ $honeyInfo->date_of_production }}', '{{ $honeyInfo->honey_type }}', {{ $honeyInfo->quantity }})">Add product info</button>
                    </td>
                </tr> 
            </tbody>
        </table>
    </div>

    <div id="modalBackdrop2" class="fixed inset-0 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add New Honey Info</h2>
            <form action="{{ route('honey.addHoney') }}" method="POST">
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

    <div id="editHoneyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-semibold">Edit Honey Info</h2>
            <form id="editHoneyForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editHoneyId">
                <input type="date" name="date_of_production" id="editHoneyDate" class="border p-2 w-full">
                <input type="text" name="honey_type" id="editHoneyType" class="border p-2 w-full">
                <input type="number" name="quantity" id="editHoneyQuantity" class="border p-2 w-full">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Update</button>
                <button type="button" onclick="closeHoneyModal()" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded-full">Cancel</button>
            </form>
        </div>
    </div>

    <div class="flex flex-wrap justify-between gap-6 mt-6">
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
                QR code data
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


    <div class="overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
    <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">
        Honey Tracing
    </h1>

    <!-- Button to Open Modal -->
    <div class="flex justify-center">
        <button class="bg-gray-500 text-white px-4 py-2 rounded-full mb-4" onclick="showModalTraceability()">
            Add New Record
        </button>
    </div>

    <!-- Traceability Table -->
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Date Collected</th>
                <th class="px-6 py-3 border">Address</th>
                <th class="px-6 py-3 border">Stage</th>
                <th class="px-6 py-3 border">Location on Map</th> <!-- New column for map -->
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traceability as $trace)
                <tr>
                    <td class="px-6 py-4 border">{{ $trace->created_at }}</td>
                    <td class="px-6 py-4 border">{{ $trace->address }}</td>
                    <td class="px-6 py-4 border">{{ ucfirst($trace->stage) }}</td>

                    <td class="px-6 py-4 border">
                        <div id="map-{{ $trace->id }}" class="w-full h-32 mb-4"></div>
                    </td>

                    <td class="px-6 py-4 border">
                        <button class="bg-gray-500 text-white px-3 py-1 rounded-full mb-4" onclick="showModalTraceability({{ $trace->id }})">
                            Edit
                        </button>
                        <form action="{{ route('traceability.destroyTraceability', $trace->id) }}" method="POST" class="inline">
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

    <!-- Add/Edit Modal -->
    <div id="addModalTraceability" class="fixed inset-0 flex items-center justify-center hidden ">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-lg font-semibold mb-4">Add Traceability Record</h2>
        <form action="{{ route('traceability.storeTraceability', ['honey_id' => $honeyInfo->id]) }}" method="POST">
            @csrf
            <label>Address:</label>
            <input type="text" id="address" name="address" class="border p-2 w-full mb-4" oninput="geocodeAddress()">
            <div id="map" class="w-full h-64 mb-4" style="height: 300px;"></div> <!-- Adjust the height if necessary -->
            <label>Stage:</label>
            <select name="stage" class="border p-2 w-full mb-4">
                <option value="laboratory">Laboratory</option>
                <option value="wholesaler">Wholesaler</option>
                <option value="packaging">Packaging</option>
            </select>
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-full">Save</button>
            <button type="button" onclick="closeModalTraceability()" class="bg-gray-500 text-white px-4 py-2 rounded-full">Cancel</button>
        </form>
    </div>
    </div>

    <!-- Traceability Laboratory Table -->
    <h2 class="flex justify-center text-md font-semibold mb-4">Traceability Laboratory</h2>
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Date Collected</th>
                <th class="px-6 py-3 border">Location</th>
                <th class="px-6 py-3 border">Stage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traceability as $trace)
                <tr>
                    <td class="px-6 py-4 border">{{ $trace->dateLaboratory }}</td>
                    <td class="px-6 py-4 border">{{ $trace->addressLaboratory }}</td>
                    <td class="px-6 py-4 border">Laboratory</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Traceability Wholesaler Table -->
    <h2 class="flex justify-center text-md font-semibold mb-4">Traceability Wholesaler</h2>
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Date Collected</th>
                <th class="px-6 py-3 border">Location</th>
                <th class="px-6 py-3 border">Stage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traceability as $trace)
                <tr>
                    <td class="px-6 py-4 border">{{ $trace->dateWholesaler }}</td>
                    <td class="px-6 py-4 border">{{ $trace->addressWholesaler }}</td>
                    <td class="px-6 py-4 border">Wholesaler</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Traceability Packaging Table -->
    <h2 class="flex justify-center text-md font-semibold mb-4">Traceability Packaging</h2>
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 py-3 border">Date Collected</th>
                <th class="px-6 py-3 border">Location</th>
                <th class="px-6 py-3 border">Stage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($traceability as $trace)
                <tr>
                    <td class="px-6 py-4 border">{{ $trace->datePackaging }}</td>
                    <td class="px-6 py-4 border">{{ $trace->addressPackaging }}</td>
                    <td class="px-6 py-4 border">Packaging</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>


    <!-- ------------------------------------------------------------------------------------------------------------- -->
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
            <form action="{{ route('beekeeper.update') }}" method="POST">
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
            <form action="{{ route('beekeeper.update') }}" method="POST">
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
    <!-- ------------------------------------------------------------------------------------------------------------- -->
    <script>
    // -----------------------------------------------------------------------------------------------------------------
            
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

    // -----------------------------------------------------------------------------------------------------------------
        function showModal() {
            document.getElementById('modalBackdrop').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('modalBackdrop').classList.add('hidden');
        }    
        function showModal2() {
            document.getElementById('modalBackdrop2').classList.remove('hidden');
        }
        function closeModal2() {
            document.getElementById('modalBackdrop2').classList.add('hidden');
        }            
        function showModal3(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal3(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        function showModal4(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal4(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }        
        function editDocument(beekeepingDocuments) {

            let docData = beekeepingDocuments;

            if (typeof docData === "string") {
                docData = JSON.parse(docData);
            }

            document.getElementById("editDocumentId").value = docData.id;
            document.getElementById("editDocumentForm").setAttribute("action", `/beekeeper/updateDocument/${docData.id}`);
            document.getElementById("editDocumentModal").classList.remove("hidden");
        }

        function closeEditModal() {
            document.getElementById('editDocumentModal').classList.add('hidden');
        }

        function editHoney(id, date, type, quantity) {
            document.getElementById('editHoneyId').value = id;
            document.getElementById('editHoneyDate').value = date;
            document.getElementById('editHoneyType').value = type;
            document.getElementById('editHoneyQuantity').value = quantity;
            document.getElementById('editHoneyForm').action = `/beekeeper/updateHoney/${id}`;
            document.getElementById('editHoneyModal').classList.remove('hidden');
        }

        function closeHoneyModal() {
            document.getElementById('editHoneyModal').classList.add('hidden');
        }

        function setupModalEventListeners() {
            document.getElementById('showFormButton').addEventListener('click', showModal);
            document.getElementById('closeModalButton').addEventListener('click', closeModal);

            document.getElementById('modalBackdrop').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });
        }


        function editModal(apiary) {
            document.getElementById('edit_apiaryId').value = apiary.id;

            const form = document.getElementById('editApiaryForm');
            form.action = form.action.replace(':id', apiary.id);

            document.getElementById('edit_description').value = apiary.description;
            document.getElementById('edit_location').value = apiary.location;
            document.getElementById('edit_floral_composition').value = apiary.floral_composition;
            document.getElementById('edit_specifics_of_environment').value = apiary.specifics_of_environment;

            showModal4('editModal');
        }
        document.addEventListener('DOMContentLoaded', setupModalEventListeners);
        

        // -----------------------------------------------------------------------------------------------------------------
        let map, marker, geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 37.7749, lng: -122.4194 },
                zoom: 12,
                mapId: '37823448a8c4cd11'
            });

            marker = new google.maps.marker.AdvancedMarkerElement({
                map: map,
                position: { lat: 37.7749, lng: -122.4194 }
            });
        }


        function geocodeAddress() {
            let address = document.getElementById('address').value;
            if (!address) return;

            geocoder.geocode({ address: address }, function (results, status) {
                if (status === 'OK') {
                    let location = results[0].geometry.location;
                    map.setCenter(location);
                    marker.position = location;
                    document.getElementById('latitude').value = location.lat();
                    document.getElementById('longitude').value = location.lng();
                } else {
                    console.error('Geocoding failed:', status);
                }
            });
        }

        function showModalTraceability() {
            document.getElementById('addModalTraceability').classList.remove('hidden');
        }

        function closeModalTraceability() {
            document.getElementById('addModalTraceability').classList.add('hidden');
        }
        </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoCstylgREVj_Kd4Ji08ah5Vp8YlkBe8s&libraries=places,marker&callback=initMap" async defer></script>
</x-app-layout>
