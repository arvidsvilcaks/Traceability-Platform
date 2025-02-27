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
          @foreach($processesWholesaler as $processesWholesaler)
          <tr>
            <td class="px-6 py-4">{{ $processesWholesaler->process }}</td>
            <td class="px-6 py-4">{{ $processesWholesaler->description }}</td>
            <td class="px-6 py-4">
                @if($processesWholesaler->add_visual_materials)
                    <a href="{{ asset('storage/' . $processesWholesaler->add_visual_materials) }}" target="_blank" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-full">View</a>
                @endif
            </td>
            <td class="px-6 py-4">
              <button onclick="editModalProcess({{ json_encode($processesWholesaler) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
              <form action="{{ route('processesWholesaler.destroyProcess', $processesWholesaler->id) }}" method="POST" style="display:inline;">
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

          <form id="addProcessForm" action="{{ route('processesWholesaler.storeProcess', ['product_id' => $honeyInfo[0]->id]) }}" method="POST" enctype="multipart/form-data">
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
          <form id="editProcessForm" action="{{ route('processesWholesaler.updateProcess', ':id') }}" method="POST" enctype="multipart/form-data">
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
            <td class="px-6 py-4">2025-02-16 11:00 AM</td>
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
            <td class="px-6 py-4">Dobele</td>
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
      @foreach($qualityWholesaler as $qualityWholesaler)
        <tr>
          <td class="px-6 py-4">{{ $qualityWholesaler->quality_standard }}</td>
          <td class="px-6 py-4">{{ $qualityWholesaler->value }}</td>
          <td class="px-6 py-3">
            <button onclick="editModalQuality({{ json_encode($qualityWholesaler) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
            
            <form action="{{ route('qualityWholesaler.destroyHoneyQuality', $qualityWholesaler->id) }}" method="POST" style="display:inline;">
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

          <form id="addQualityForm" action="{{ route('qualityWholesaler.storeHoneyQuality', ['product_id' => $honeyInfo[0]->id]) }}" method="POST" enctype="multipart/form-data">
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
          <form id="editQualityForm" action="{{ route('qualityWholesaler.updateHoneyQuality', ':id') }}" method="POST" enctype="multipart/form-data">
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

  <div class="overflow-x-auto shadow-md sm:rounded-lg mt-6">
    <table class="w-full text-sm text-center rtl:text-right text-gray-500">
      <h1 class="flex justify-center text-lg font-semibold mb-4">Information about selling further for packaging</h1>
      <div class="flex justify-center">
        <button onclick="showModalMarket('addModalMarket')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">Add new row</button>
      </div>
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
          <th class="px-6 py-3">Market Name</th>
          <th class="px-6 py-3">Location</th>
          <th class="px-6 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach($market as $market)
        <tr>
          <td class="px-6 py-4">{{ $market->market_name }}</td>
          <td class="px-6 py-4">{{ $market->market_location }}</td>
          <td class="px-6 py-3">
            <button onclick="editModalMarket({{ json_encode($market) }})" class="bg-gray-500 text-white px-2 py-1 mb-4 rounded-full">Edit</button>
            <form action="{{ route('market.destroyMarket', $market->id) }}" method="POST" style="display:inline;">
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

  <div id="addModalMarket" class="fixed inset-0 flex items-center justify-center hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-lg font-semibold mb-4">Add Market</h2>

          <form id="addMarketForm" action="{{ route('market.storeMarket', ['product_id' => $honeyInfo[0]->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="marketId" name="id">
              <input type="hidden" name="product_id" value="{{ $honeyInfo[0]->id }}">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="market_name" id="add_market_name" placeholder="Market name" required class="border p-2 rounded">
                  <input type="text" name="market_location" id="add_market_location" placeholder="Location" required class="border p-2 rounded">
                  
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalMarket('addModalMarket')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
                  </div>
              </div>
          </form>
      </div>
  </div>

  <div id="editModalMarket" class="fixed inset-0 flex items-center justify-center hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-lg font-semibold mb-4">Edit Market</h2>
          <form id="editMarketForm" action="{{ route('market.updateMarket', ':id') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" id="edit_marketId" name="id">

              <div class="flex flex-col space-y-2">
                  <input type="text" name="market_name" id="add_quality_standard" placeholder="Market name" required class="border p-2 rounded">
                  <input type="text" name="market_location" id="add_market_location" placeholder="Location" required class="border p-2 rounded">
        
                  <div class="flex justify-between mt-4">
                      <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Save</button>
                      <button type="button" onclick="closeModalMarket('editModalMarket')" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full">Cancel</button>
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

    function editModalProcess($processesWholesaler) {
        document.getElementById('edit_processId').value = $processesWholesaler.id;
        document.getElementById('add_process').value = $processesWholesaler.processes;
        document.getElementById('add_description').value = $processesWholesaler.description;

        let form = document.getElementById('editProcessForm');
        form.action = form.action.replace(':id', $process.id);

        showModalProcess('editModalProcess');
    }

    function showModalQuality(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalQuality(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalQuality($qualityWholesaler) {
        document.getElementById('edit_qualityId').value = $qualityWholesaler.id;
        document.getElementById('add_quality_standard').value = $qualityWholesaler.quality_standard;
        document.getElementById('add_value').value = $qualityWholesaler.value;

        let form = document.getElementById('editQualityForm');
        form.action = form.action.replace(':id', $qualityWholesaler.id);

        showModalProcess('editModalQuality');
    }

    function showModalMarket(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModalMarket(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function editModalMarket($market) {
        document.getElementById('edit_marketId').value = $market.id;
        document.getElementById('add_market_name').value = $market.market_name;
        document.getElementById('add_market_location').value = $market.market_location;

        let form = document.getElementById('editMarketForm');
        form.action = form.action.replace(':id', $market.id);

        showModalProcess('editModalMarket');
    }
  </script>
</x-app-layout>
