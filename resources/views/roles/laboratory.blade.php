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
                                    View File
                                </a>
                            </p>
                            <form action="{{ route('analysis.deleteAnalysis', ['id' => $honeyInfo->id]) }}" method="POST">
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


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200"">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Info about collected honey</h1>
            <div class="flex justify-center mb-6">
                <button id="addNewRowBtn" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full" onclick="showModalTrace('addModalTrace')">Add new row</button>
            </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Collection date</th>
                    <th class="px-6 py-3 border">Address</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($traceabilityLaboratory->count() > 0)
                    <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('addNewRowBtn').style.display = 'none');</script>
                @endif
                @foreach ($traceabilityLaboratory as $traceabilityLaboratory)
                    <tr>
                        <td class="px-6 py-4 border">{{ $traceabilityLaboratory->dateLaboratory}}</td>
                        <td class="px-6 py-4 border">{{ $traceabilityLaboratory->addressLaboratory}}</td>
                        <td class="px-6 py-4 border">
                        <button onclick="editModalTrace({{ json_encode($traceabilityLaboratory) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                        <form method="POST" action="{{ route('traceabilityLaboratory.removeLaboratoryTrace', $traceabilityLaboratory->id) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="addModalTrace" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Add Traceability Information</h2>
            <form action="{{ route('traceabilityLaboratory.storeLaboratoryTrace', $honeyInfo->id) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">
                <div class="flex flex-col space-y-2">
                    <input type="date" name="dateLaboratory" id="add_dateLaboratory" placeholder="Date" required>
                    <input type="text" name="addressLaboratory" id="add_addressLaboratory" placeholder="Address" required>
                    
                    <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalTrace('addModalTrace')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                  </div>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalTrace" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Edit Trace</h2>
            <form id="editTraceForm" action="{{ route('traceabilityLaboratory.updateLaboratoryTrace', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_TraceId" name="id">

                <div class="flex flex-col space-y-2">
                    <input type="date" name="dateLaboratory" id="add_dateLaboratory" placeholder="Date" required>
                    <input type="text" name="addressLaboratory" id="add_addressLaboratory" placeholder="Address" required>

                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalTrace('editModalTrace')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        checkRowExists();
    });

    function checkRowExists() {
        let tbody = document.querySelector("#traceTable tbody");
        let addNewRowBtn = document.getElementById("addNewRowBtn");

        if (tbody.children.length > 0) {
            addNewRowBtn.style.display = "none";
        } else {
            addNewRowBtn.style.display = "block";
        }
    }

    function showModalTrace(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalTrace(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function editModalTrace($traceabilityLaboratory) {
        document.getElementById('edit_TraceId').value = $traceabilityLaboratory.id;
        document.getElementById('add_dateLaboratory').value = $traceabilityLaboratory.dateLaboratory;
        document.getElementById('add_addressLaboratory').value = $traceabilityLaboratory.addressLaboratory;

        let form = document.getElementById('editTraceForm');
        form.action = form.action.replace(':id', $traceabilityLaboratory.id);

        showModalTrace('editModalTrace');
    }
    </script>
</x-app-layout>
