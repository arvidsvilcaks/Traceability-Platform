<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Traceability platform') }}
        </h2>
    </x-slot>

    @if(auth()->user()->role != 'Beekeeping association' && auth()->user()->role != 'Administrator')

    @if(auth()->user()->role != 'Packaging company')

    <!-- HONEY LIST -->

    <div class="container mx-auto mt-8">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-4">Honey List</h1>

        @if(auth()->user()->role == 'Beekeeper')
            <div class="flex justify-center mb-4">
                <button onclick="showModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                    Add New Honey
                </button>
            </div>
        @endif

        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Name</th>
                    <th class="px-6 py-3 border">Apiary</th>
                    @if(auth()->user()->role == 'Beekeeper' || auth()->user()->role == 'Laboratory employee')
                        <th class="px-6 py-3 border">Action</th>
                    @elseif(auth()->user()->role == 'Wholesaler')
                        <th class="px-6 py-3 border">Beekeeper (Producer)</th>
                        <th class="px-6 py-3 border">Quantity (kg)</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($honeyInfo as $honey)
                <tr>
                    <td class="px-6 py-4 border">{{ $honey->name }}</td>
                    <td class="px-6 py-4 border">{{ $honey->apiary->description ?? 'No Apiary Assigned' }}</td>
                    <td class="px-6 py-4 border">
                        @if(auth()->user()->role == 'Beekeeper' && $honey->beekeeper_id == auth()->user()->id)
                            <a href="{{ route('beekeeper.index', ['honey_id' => $honey->id]) }}" 
                            class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                View Beekeeper Data
                            </a>
                            <div class="ml-6">
                                <button onclick="showEditModal({{ $honey->id }}, '{{ $honey->name }}', '{{ $honey->apiary_id }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-4">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.delete', $honey->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @elseif(auth()->user()->role == 'Laboratory employee' && $honey->laboratory_id == auth()->user()->id)
                            <a href="{{ route('laboratory.index', ['honey_id' => $honey->id]) }}" 
                            class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                View Lab Data
                            </a>
                        @elseif(auth()->user()->role == 'Wholesaler' && $honey->wholesaler_id == auth()->user()->id)
                            <p>{{ $honey->beekeeper->company ?? 'Unknown' }}</p>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->role == 'Wholesaler' && $honey->wholesaler_id == auth()->user()->id)
                            <p>{{ $honey->quantity }}</p>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @endif

    @if(auth()->user()->role == 'Beekeeper')
    <div id="addHoneyModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Add New Honey</h2>
            <form action="{{ route('dashboard.store') }}" method="POST">
                @csrf
                <label class="block mb-2">Honey Name:</label>
                <input type="text" name="name" required class="w-full border p-2 rounded">    

                <label class="block mb-2 mt-4">Select Apiary:</label>
                <select name="apiary_id" required class="w-full border p-2 rounded">
                    <option value="">Select an Apiary</option>
                    @foreach($apiaryInfo as $apiary)
                        <option value="{{ $apiary->id }}">{{ $apiary->description }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="beekeeper_id" value="{{ auth()->user()->id }}">

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editProductModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Honey</h2>
            <form id="editProductForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProductId" name="id">
                
                <label class="block mb-2">Honey Name:</label>
                <input type="text" id="editProductName" name="name" required class="w-full border p-2 rounded">

                <label class="block mb-2 mt-4">Select Apiary:</label>
                <select id="editApiarySelect" name="apiary_id" required class="w-full border p-2 rounded">
                    <option value="">Select an Apiary</option>
                    @foreach($apiaryInfo as $apiary)
                        <option value="{{ $apiary->id }}">{{ $apiary->description }}</option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    @endif

    <!-- APIARY LIST -->
    @if(auth()->user()->role == 'Beekeeper')
    
    <div class="container mx-auto mt-6 mb-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-4">Apiary List</h1>

            <div class="flex justify-center mb-4">
                <button onclick="showApiaryModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                    Add New Apiary
                </button>
            </div>

            <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border">Description</th>
                        <th class="px-6 py-3 border">Location</th>
                        <th class="px-6 py-3 border">Floral Composition</th>
                        <th class="px-6 py-3 border">Specifics of Environment</th>
                        <th class="px-6 py-3 border">Visual Materials</th>
                        @if(auth()->user()->role == 'Beekeeper')
                            <th class="px-6 py-3 border">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($apiaryInfo as $apiary)
                    <tr>
                        <td class="px-6 py-4 border">{{ $apiary->description }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->location }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->floral_composition }}</td>
                        <td class="px-6 py-4 border">{{ $apiary->specifics_of_environment }}</td>
                        <td class="px-6 py-4 border">
                            @if($apiary->add_visual_materials)
                                <a href="{{ asset('storage/' . $apiary->add_visual_materials) }}" target="_blank" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">View File</a>
                            @else
                                <span class="text-gray-500">No File</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 border">
                            @if(auth()->user()->role == 'Beekeeper' && $apiary->beekeeper_id == auth()->user()->id)
                                <button onclick="showEditApiaryModal({{ $apiary->id }}, '{{ $apiary->description }}', '{{ $apiary->location }}', '{{ $apiary->floral_composition }}', '{{ $apiary->specifics_of_environment }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.destroyApiary', $apiary->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div id="addApiaryModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Add New Apiary</h2>
                <form action="{{ route('dashboard.storeApiary') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2">Description:</label>
                    <input type="text" name="description" required class="w-full border p-2 rounded">    
                    <label class="block mb-2 mt-4">Location:</label>
                    <input type="text" name="location" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Floral Composition:</label>
                    <input type="text" name="floral_composition" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Specifics of Environment:</label>
                    <input type="text" name="specifics_of_environment" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Add Visual Materials (PDF, DOCX):</label>
                    <input type="file" name="add_visual_materials" class="w-full border p-2 rounded">
                    <input type="hidden" name="beekeeper_id" value="{{ auth()->user()->id }}">

                    <div class="mt-4 flex justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                        <button type="button" onclick="hideApiaryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="editApiaryModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Edit Apiary</h2>
                <form id="editApiaryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editApiaryId" name="id">
                    <label class="block mb-2">Description:</label>
                    <input type="text" id="editApiaryDescription" name="description" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Location:</label>
                    <input type="text" id="editApiaryLocation" name="location" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Floral Composition:</label>
                    <input type="text" id="editApiaryFloralComposition" name="floral_composition" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Specifics of Environment:</label>
                    <input type="text" id="editApiarySpecificsOfEnvironment" name="specifics_of_environment" required class="w-full border p-2 rounded">
                    <label class="block mb-2 mt-4">Add Visual Materials (PDF, DOCX):</label>
                    <input type="file" name="add_visual_materials" class="w-full border p-2 rounded">

                    <div class="mt-4 flex justify-between">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                        <button type="button" onclick="hideEditApiaryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    @endif


    @if(auth()->user()->role == 'Wholesaler' || auth()->user()->role == 'Packaging company')

    <!-- PRODUCT LIST -->

    <div class="container">
        <h3 class="flex justify-center text-lg font-semibold mb-4 mt-4">Products List</h3>
        @if(auth()->user()->role == 'Wholesaler')

        <div class="flex justify-center mt-4 mb-4">
            <button onclick="showProductModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                Add New Product
            </button>
        </div>
        @endif
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Name</th>
                    <th class="px-6 py-3 border">Bleneded Honey's</th>
                    <th class="px-6 py-3 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $products)
                    <tr class="border-t">
                        <td class="px-6 py-4 border">{{ $products->name }}</td>
                        <td class="px-6 py-4 border">
                            @foreach($products->honeys as $honey)
                                {{ $honey->name }}<br>
                            @endforeach
                        </td>

                        @if(auth()->user()->role == 'Wholesaler' && $products->wholesaler_id == auth()->user()->id)

                        <td class="px-6 py-4 border">
                            <div>
                                <button onclick="showEditProduct({{ $products->id }}, '{{ $products->name }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-4">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.product.deleteProduct', $products->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    Delete
                                </button>
                                <a href="{{ route('wholesaler.index', ['product_id' => $products->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Product
                                </a>
                                </form>
                            </div>
                        </td>

                        @elseif(auth()->user()->role == 'Packaging company' && $products->packaging_id == auth()->user()->id)
                        <td class="px-6 py-4 border">
                            <div>
                                <button onclick="showEditProduct({{ $products->id }}, '{{ $products->name }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-4">
                                    Edit
                                </button>
                                <form action="{{ route('dashboard.product.deleteProduct', $products->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    Delete
                                </button>
                                <a href="{{ route('packaging.index', ['product_id' => $products->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Product
                                </a>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div id="productModal" class="modal fixed inset-0 flex items-center justify-center hidden">
            <div class="modal-dialog bg-white rounded-lg shadow-lg w-full max-w-lg">
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold" id="productModalLabel">Manage Products</h5>
                    <button type="button" onclick="hideProductModal()" class="text-black font-bold text-2xl">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('dashboard.product.storeProduct') }}" method="POST">
                        @csrf
                        <input type="hidden" name="wholesaler_id" value="{{ auth()->user()->id }}">

                        <div class="form-group mb-4">
                            <label for="name" class="block text-gray-700">Product Name:</label>
                            <input type="text" name="name" class="form-control w-full p-2 border border-gray-300 rounded-md" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="block text-gray-700">Available Honey's:</label>
                            <div class="space-y-2">
                                @foreach($honeyInfo as $honey)
                                    @if($honey->is_available)
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="honey_ids[]" value="{{ $honey->id }}" id="honey_{{ $honey->id }}" class="form-checkbox text-gray-600">
                                            <label for="honey_{{ $honey->id }}" class="text-gray-800">{{ $honey->name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-700">Create Product</button>
                    </form>
                </div>
            </div>
        </div>


        <div id="editProductModal2" class="fixed inset-0 flex justify-center items-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold mb-4">Edit Product</h3>
                <form id="editProductForm2" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="editProductName2" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" id="editProductName2" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="editProductId2" class="block text-sm font-medium text-gray-700">Product ID</label>
                        <input type="text" id="editProductId2" name="id" class="w-full px-4 py-2 border border-gray-300 rounded-md" readonly>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="hideEditProduct()" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endif

    <script>
    function showApiaryModal() {
        document.getElementById('addApiaryModal').classList.remove('hidden');
    }

    function hideApiaryModal() {
        document.getElementById('addApiaryModal').classList.add('hidden');
    }

    function showEditApiaryModal(id, description, location, floral_composition, specifics_of_environment) {
        document.getElementById('editApiaryId').value = id;
        document.getElementById('editApiaryDescription').value = description;
        document.getElementById('editApiaryLocation').value = location;
        document.getElementById('editApiaryFloralComposition').value = floral_composition;
        document.getElementById('editApiarySpecificsOfEnvironment').value = specifics_of_environment;
        document.getElementById('editApiaryForm').action = '/dashboard/updateApiary/' + id;

        document.getElementById('editApiaryModal').classList.remove('hidden');
    }

    function hideEditApiaryModal() {
        document.getElementById('editApiaryModal').classList.add('hidden');
    }

    // --------------------------------------------------------------------------------------------

    function showModal() {
        document.getElementById('addHoneyModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('addHoneyModal').classList.add('hidden');
    }
    function showEditModal(id, name, apiary_id) {
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editApiarySelect').value = apiary_id;
        document.getElementById('editProductForm').action = '/dashboard/update/' + id;

        document.getElementById('editProductModal').classList.remove('hidden');
    }

    function hideEditModal() {
        document.getElementById('editProductModal').classList.add('hidden');
    }

    // --------------------------------------------------------------------------------------------

    function showProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.remove('hidden');
    }

    function hideProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
    }

    function showEditProduct(id, name) {
            document.getElementById('editProductModal2').classList.remove('hidden');
            document.getElementById('editProductId2').value = id;
            document.getElementById('editProductName2').value = name;
            document.getElementById('editProductForm2').action = '/dashboard/product/updateProduct/' + id;
        }

    function hideEditProduct() {
        document.getElementById('editProductModal2').classList.add('hidden');
    }
    </script>
</x-app-layout>