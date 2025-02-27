<x-app-layout>
<div class="grid grid-cols-1 gap-4 mt-6">
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-center rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <h1 class="flex justify-center text-lg font-semibold mb-4">Description of processes</h1>
          <div class="flex justify-center">
                <button onclick="showModalProcess('addModalProcess')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
            </div>
          <tr>
            <th class="px-6 py-3">Process</th>
            <th class="px-6 py-3">Description</th>
            <th class="px-6 py-3">Visual materials</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($processesPackaging as $processesPackaging)
          <tr>
            <td class="px-6 py-4">{{ $processesPackaging->process }}</td>
            <td class="px-6 py-4">{{ $processesPackaging->description }}</td>
            <td class="px-6 py-4">
                @if($processesPackaging->add_visual_materials)
                    <a href="{{ asset('storage/' . $processesPackaging->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                @endif
            </td>
            <td class="px-6 py-4">
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

          <form id="addProcessForm" action="{{ route('processesPackaging.storeProcess', ['product_id' => $honeyInfo[0]->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="processId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo[0]->id }}">

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

  <div class="grid grid-cols-2 gap-4 mt-6">
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-center rtl:text-right text-gray-500">
        <h1 class="flex bg-slate-100 justify-center text-2xl">QR code data</h1>
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

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-center rtl:text-right text-gray-500">
          <h1 class="flex bg-slate-100 justify-center text-2xl">Info about collected honey</h1>
          <div class="flex justify-center">
                <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
            </div>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th class="px-6 py-3">Collection date</th>
            <th class="px-6 py-3">Location</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-6 py-4">2025-02-16 11:00 AM</td>
            <td class="px-6 py-4">Jelgava</td>
            <td class="px-6 py-4">
              <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
              <button class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6">
    <table class="w-full text-sm text-center rtl:text-right text-gray-500">
      <h1 class="flex justify-center text-lg font-semibold mb-4">Honey quality</h1>
      <div class="flex justify-center">
        <button onclick="showModalQuality('addModalQuality')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
      </div>
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
          <th class="px-6 py-3">Quality Assessment</th>
          <th class="px-6 py-3">Value</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($qualityPackaging as $qualityPackaging)
        <tr>
          <td class="px-6 py-4">{{ $qualityPackaging->quality_standard }}</td>
          <td class="px-6 py-4">{{ $qualityPackaging->value }}</td>
          <td class="px-6 py-3">
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

          <form id="addQualityForm" action="{{ route('qualityPackaging.storeHoneyQuality', ['product_id' => $honeyInfo[0]->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="qualityId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo[0]->id }}">

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
  </script>
</x-app-layout>