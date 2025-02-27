<x-app-layout>
    <div class="space-y-10">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full mb-6 mt-6">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Info about apiary</h1>
            
            <div class="flex justify-center">
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

                    <form id="addApiaryForm" action="{{ route('apiary.storeApiary', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="apiaryId" name="id">
                        <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

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

        <h3 class="text-lg font-semibold flex justify-center">Documents about Beekeeping Practices</h3>
        <div class="flex justify-center">
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

        <div id="modalBackdrop" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Add New Document</h2>
                <form action="{{ route('beekeepingDocuments.addDocument', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

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

        <h3 class="text-lg font-semibold flex justify-center mt-4">Info about Produced Honey</h3>
        <div class="flex justify-center">
            <button id="showFormButton2" class="justify-center bg-gray-500 text-white px-4 py-2 rounded-full mt-4">Add New Row</button>
        </div>
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
                        <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full" onclick="editHoney({{ $honeyInfo->id }}, '{{ $honeyInfo->date_of_production }}', '{{ $honeyInfo->honey_type }}', {{ $honeyInfo->quantity }})">Edit</button>
                        <form action="{{ route('products.deleteProduct', $honeyInfo->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-500 text-white px-2 py-1 rounded-full">Delete</button>
                        </form>
                    </td>
                </tr>
                
            </tbody>
        </table>

        <div id="modalBackdrop2" class="fixed inset-0 hidden flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold mb-4">Add New Honey Info</h2>
                <form action="{{ route('products.addProduct') }}" method="POST">
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

        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">Results of honey analysis</h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 border">View results</th>
                </tr>
            </thead>
            <tbody>
                @if($latestAnalysis)
                    <tr>
                        <td class="px-6 py-4 border">
                            <a href="{{ asset('storage/' . $latestAnalysis->add_analysis_results) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full" target="_blank">
                                View
                            </a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="px-6 py-4 border text-gray-500">No analysis results available</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">QR code data</h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">QR Code</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4">
                        <a href="{{ route('qr_code', ['qr_code' => $honeyInfo->qr_code]) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <h1 class="flex bg-slate-100 justify-center text-2xl mt-6">Honey tracing (buyer, location of product, packaging company who handles honey, honey blending)</h1>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Date Collected (Laboratory Company)</th>
                    <th class="px-6 py-3 border">Location (Laboratory Company)</th>
                    <th class="px-6 py-3 border">Date Collected (Wholesaler Company)</th>
                    <th class="px-6 py-3 border">Location (Wholesaler Company)</th>
                    <th class="px-6 py-3 border">Date Collected (Packaging Company)</th>
                    <th class="px-6 py-3 border">Location (Packaging Company)</th>
                </tr>
            </thead>    
            <tbody>
                <tr>
                    <td class="px-6 py-4 border">20.04.2024.</td>
                    <td class="px-6 py-4 border">Jelgava</td>
                    <td class="px-6 py-4 border">20.04.2024.</td>
                    <td class="px-6 py-4 border">Jelgava</td>
                    <td class="px-6 py-4 border">20.04.2024.</td>
                    <td class="px-6 py-4 border">Jelgava</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
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
            document.getElementById('editHoneyForm').action = `/beekeeper/updateProduct/${id}`;
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

        function setupModalEventListeners2() {
            document.getElementById('showFormButton2').addEventListener('click', showModal2);
            document.getElementById('closeModalButton2').addEventListener('click', closeModal2);

            document.getElementById('modalBackdrop2').addEventListener('click', function(event) {
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
        document.addEventListener('DOMContentLoaded', setupModalEventListeners2);
        
    </script>
    
</x-app-layout>
