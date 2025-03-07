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



  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
      <h1 class="flex justify-center text-lg font-semibold mb-4">Honey quality</h1>
      <div class="flex justify-center mb-6">
        <button onclick="showModalQuality('addModalQuality')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
      </div>
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
          <th class="px-6 py-3 border">Metric</th>
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
          <form id="editQualityForm" action="{{ route('qualityPackaging.updateHoneyQuality', ':id') }}" method="POST" enctype="multipart/form-data">
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

  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6 mb-6">
    <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
      <h1 class="flex justify-center text-lg font-semibold mb-4">Packages</h1>
      <div class="flex justify-center mb-6">
        <button onclick="showModalPackages('addModalPackages')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
      </div>
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
          <th class="px-6 py-3 border">Quantity</th>
          <th class="px-6 py-3 border">Type</th>
          <th class="px-6 py-3 border">Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($packages as $packages)
        <tr>
          <td class="px-6 py-4 border">{{ $packages->quantity }}</td>
          <td class="px-6 py-4 border">{{ $packages->type }}</td>
          <td class="px-6 py-4 border">
            <button onclick="editModalPackages({{ json_encode($packages) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
            
            <form action="{{ route('packages.destroyPackage', $packages->id) }}" method="POST" style="display:inline;">
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
                  <input type="number" name="quantity" id="add_quantity" placeholder="Quantity" required class="border p-2 rounded">
                  <input type="text" name="type" id="add_type" placeholder="Type" required class="border p-2 rounded">
        
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalPackages('editModalPackages')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
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
        document.getElementById('add_quantity').value = $packages.quantity;
        document.getElementById('add_type').value = $packages.type;

        let form = document.getElementById('editPackagesForm');
        form.action = form.action.replace(':id', $packages.id);

        showModalProcess('editModalPackages');
    }

  </script>
</x-app-layout>