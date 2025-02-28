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
                  <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded-full">Delete</button>
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

  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6">
      <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
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
            @if ($traceabilityPackaging->count() > 0)
                <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('addNewRowBtn').style.display = 'none');</script>
            @endif
              @foreach ($traceabilityPackaging as $traceabilityPackaging)
                  <tr>
                      <td class="px-6 py-4 border">{{ $traceabilityPackaging->datePackaging}}</td>
                      <td class="px-6 py-4 border">{{ $traceabilityPackaging->addressPackaging}}</td>
                      <td class="px-6 py-4 border">
                      <button onclick="editModalTrace({{ json_encode($traceabilityPackaging) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
                      <form method="POST" action="{{ route('traceabilityPackaging.removePackagingTrace', $traceabilityPackaging->id) }}" style="display: inline-block;">
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
          <form action="{{ route('traceabilityPackaging.storePackagingTrace', $honeyInfo->id) }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">
              <div class="flex flex-col space-y-2">
                  <input type="date" name="datePackaging" id="add_datePackaging" placeholder="Date" required>
                  <input type="text" name="addressPackaging" id="add_addressPackaging" placeholder="Address" required>
                  
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
          <form id="editTraceForm" action="{{ route('traceabilityPackaging.updatePackagingTrace', ':id') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" id="edit_TraceId" name="id">

              <div class="flex flex-col space-y-2">
                  <input type="date" name="datePackaging" id="add_datePackaging" placeholder="Date" required>
                  <input type="text" name="addressPackaging" id="add_addressPackaging" placeholder="Address" required>

                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalTrace('editModalTrace')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
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
          <th class="px-6 py-3 border">Quality Assessment</th>
          <th class="px-6 py-3 border">Value</th>
          <th class="px-6 py-3 border">Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($qualityPackaging as $qualityPackaging)
        <tr>
          <td class="px-6 py-4 border">{{ $qualityPackaging->quality_standard }}</td>
          <td class="px-6 py-4 border">{{ $qualityPackaging->value }}</td>
          <td class="px-6 py-4 border">
            <button onclick="editModalQuality({{ json_encode($qualityPackaging) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
            
            <form action="{{ route('qualityPackaging.destroyHoneyQuality', $qualityPackaging->id) }}" method="POST" style="display:inline;">
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

          <form id="addQualityForm" action="{{ route('qualityPackaging.storeHoneyQuality', ['product_id' => $honeyInfo->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="qualityId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo->id }}">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="quality_standard" id="add_quality_standard" placeholder="Quality standard" required class="border p-2 rounded">
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
          <form id="editQualityForm" action="{{ route('qualityPackaging.updateHoneyQuality', ':id') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" id="edit_qualityId" name="id">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="quality_standard" id="add_quality_standard" placeholder="Quality standard" required class="border p-2 rounded">
                  <input type="text" name="value" id="add_value" placeholder="Value" required class="border p-2 rounded">
        
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalQuality('editModalQuality')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
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
        document.getElementById('add_quality_standard').value = $qualityPackaging.quality_standard;
        document.getElementById('add_value').value = $qualityPackaging.value;

        let form = document.getElementById('editQualityForm');
        form.action = form.action.replace(':id', $qualityPackaging.id);

        showModalProcess('editModalQuality');
    }

    function showModalTrace(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalTrace(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function editModalTrace($traceabilityPackaging) {
        document.getElementById('edit_TraceId').value = $traceabilityPackaging.id;
        document.getElementById('add_datePackaging').value = $traceabilityPackaging.datePackaging;
        document.getElementById('add_addressPackaging').value = $traceabilityPackaging.addressPackaging;

        let form = document.getElementById('editTraceForm');
        form.action = form.action.replace(':id', $traceabilityPackaging.id);

        showModalTrace('editModalTrace');
    }
  </script>
</x-app-layout>