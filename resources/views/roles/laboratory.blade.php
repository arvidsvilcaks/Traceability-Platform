<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">
            Provide Honey Analysis Results
        </h1>

        <table class="w-full text-sm text-center rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Action</th>
                    <th scope="col" class="px-6 py-3">File</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4">
                        @if(isset($analysis))
                            <form action="{{ route('analysis.updateAnalysis', ['id' => $analysis->id]) }}" 
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
                    <td class="px-6 py-4 text-center">
                        @if(isset($analysis) && $analysis->add_analysis_results)
                            <p class="text-gray-700">
                                Uploaded file: 
                                <a href="{{ asset('storage/' . $analysis->add_analysis_results) }}" 
                                class="text-blue-500 underline" target="_blank">
                                    View File
                                </a>
                            </p>
                            <form action="{{ route('analysis.deleteAnalysis', ['id' => $analysis->id]) }}" method="POST">
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
        <table class="w-full text-sm text-center rtl:text-right text-gray-500">
            <h1 class="flex justify-center text-lg font-semibold mb-4">Info about collected honey</h1>
            <div class="flex justify-center">
                <button id="addNewRowBtn" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full" onclick="showModalTrace('addModalTrace')">Add new row</button>
            </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Collection date</th>
                    <th class="px-6 py-3">Location (Latitude)</th>
                    <th class="px-6 py-3">Location (Longitude)</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($traceabilityLaboratory as $traceabilityLaboratory)
                    <tr>
                        <td class="px-6 py-4">{{ $traceabilityLaboratory->dateLaboratory}}</td>
                        <td class="px-6 py-4">{{ $traceabilityLaboratory->latitudeLaboratory}}</td>
                        <td class="px-6 py-4">{{ $traceabilityLaboratory->longitudeLaboratory}}</td>
                        <td class="px-6 py-4">
                        <button onclick="editModalTrace({{ json_encode($traceabilityLaboratory) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                        <form method="POST" action="{{ route('traceabilityLaboratory.deleteLaboratoryTrace', $traceabilityLaboratory->id) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Delete</button>
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
            <form action="{{ route('traceabilityLaboratory.storeLaboratoryTrace', $analysis->id) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $analysis->id }}">
                <div class="flex flex-col space-y-2">
                    <input type="date" name="dateLaboratory" id="add_dateLaboratory" placeholder="Date" required>
                    <input type="number" name="latitudeLaboratory" id="add_latitudeLaboratory" placeholder="Latitude" required>
                    <input type="number" name="longitudeLaboratory" id="add_longitudeLaboratory" placeholder="Longitude" required>
                    
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
                    <input type="number" name="latitudeLaboratory" id="add_latitudeLaboratory" placeholder="Latitude" required>
                    <input type="number" name="longitudeLaboratory" id="add_longitudeLaboratory" placeholder="Longitude" required>

                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                        <button type="button" onclick="closeModalTrace('editModalTrace')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6" >
        <table class="w-full text-sm text-center rtl:text-right text-gray-500">
        <h1 class="flex bg-slate-100 justify-center text-2xl mb-4">QR code data</h1>
        <div class="flex justify-center">
                <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add data</button>
        </div>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">QR Code ID</th>
                    <th class="px-6 py-3">Scan Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4">QR1234</td>
                    <td class="px-6 py-4">2025-02-16 10:30 AM</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
    function showModalTrace(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalTrace(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function editModalTrace($traceabilityLaboratory) {
        document.getElementById('edit_TraceId').value = $traceabilityLaboratory.id;
        document.getElementById('add_dateLaboratory').value = $traceabilityLaboratory.dateLaboratory;
        document.getElementById('add_latitudeLaboratory').value = $traceabilityLaboratory.latitudeLaboratory;
        document.getElementById('add_longitudeLaboratory').value = $traceabilityLaboratory.longitudeLaboratory;

        let form = document.getElementById('editTraceForm');
        form.action = form.action.replace(':id', $traceabilityLaboratory.id);

        showModalTrace('editModalTrace');
    }
    </script>
</x-app-layout>
