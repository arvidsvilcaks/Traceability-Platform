<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Traceability platform') }}
        </h2>
    </x-slot>

    @if(auth()->user()->role != 'Beekeeping association' && auth()->user()->role != 'Administrator')

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
                    <th class="px-6 py-3 border">Product Name</th>
                    <th class="px-6 py-3 border">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($honeys as $honey)
                <tr>
                    <td class="px-6 py-4 border">{{ $honey->name }}</td>
                    <td class="px-6 py-4 border">
                        @if(auth()->user()->role == 'Beekeeper' && $honey->beekeeper_id == auth()->user()->id)
                            <a href="{{ route('beekeeper.index', ['honey_id' => $honey->id]) }}" 
                            class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                View Beekeeper Data
                            </a>
                            <div class="ml-6">
                                <button onclick="showEditModal({{ $honey->id }}, '{{ $honey->name }}')" class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700 mt-4">
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
                            <!-- <a href="{{ route('wholesaler.index', ['product_id' => $honey->id]) }}" 
                            class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                            </a> -->
                            <button class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">View Honey Data</button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if(auth()->user()->role == 'Wholesaler')
    <div class="container">

        <!-- Product Table -->
        <h3 class="mt-8 text-xl font-semibold flex justify-center mt-4">Products List</h3>
        <div class="flex justify-center mt-4 mb-4">
            <button onclick="showProductModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                Add New Product
            </button>
        </div>
        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200 mb-6">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border">Name</th>
                    <th class="px-6 py-3 border">Honeys</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Modal Window for Product Table -->
        <div id="productModal" class="modal fixed inset-0 flex items-center justify-center hidden">
            <div class="modal-dialog bg-white rounded-lg shadow-lg w-full max-w-lg">
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold" id="productModalLabel">Manage Products</h5>
                    <button type="button" onclick="hideProductModal()" class="text-black font-bold text-2xl">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <!-- Product Form -->
                    <form action="{{ route('dashboard.product.storeProduct') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="block text-gray-700">Product Name:</label>
                            <input type="text" name="name" class="form-control w-full p-2 border border-gray-300 rounded-md" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="honey_ids" class="block text-gray-700">Select Honeys:</label>
                            <select name="honey_ids[]" class="form-control w-full p-2 border border-gray-300 rounded-md" multiple required>
                                @foreach($honeyInfo as $honey)
                                    <option value="{{ $honey->id }}">{{ $honey->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-700">Create Product</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
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



    @if(auth()->user()->role == 'Beekeeper')
    <div id="addHoneyModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Add New Product</h2>
            <form action="{{ route('dashboard.store') }}" method="POST">
                @csrf
                <label class="block mb-2">Product Name:</label>
                <input type="text" name="name" required class="w-full border p-2 rounded">
                
                <label class="block mt-4">Assign Beekeeper:</label>
                <select name="beekeeper_id" class="w-full border p-2 rounded">
                    <option value="">None</option>    
                    @foreach($beekeepers as $beekeeper)
                        <option value="{{ $beekeeper->id }}">{{ $beekeeper->name }}</option>
                    @endforeach
                </select>

                <label class="block mt-4">Assign Laboratory Employee:</label>
                <select name="laboratory_id" class="w-full border p-2 rounded">
                    <option value="">None</option>    
                    @foreach($laboratoryEmployees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>

                <label class="block mt-4">Assign Wholesaler:</label>
                <select name="wholesaler_id" class="w-full border p-2 rounded">
                    <option value="">None</option>
                    @foreach($wholesalers as $wholesaler)
                        <option value="{{ $wholesaler->id }}">{{ $wholesaler->name }}</option>
                    @endforeach
                </select>

                <label class="block mt-4">Assign Packaging Company:</label>
                <select name="packaging_id" class="w-full border p-2 rounded">
                    <option value="">None</option>    
                    @foreach($packagingCompanies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>

                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editProductModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Product</h2>
            <form id="editProductForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editProductId" name="id">
                <label class="block mb-2">Product Name:</label>
                <input type="text" id="editProductName" name="name" required class="w-full border p-2 rounded">
                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" onclick="hideEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <script>
    function showModal() {
        document.getElementById('addHoneyModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('addHoneyModal').classList.add('hidden');
    }
    function showEditModal(id, name) {
        document.getElementById('editProductModal').classList.remove('hidden');
        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editProductForm').action = '/dashboard/update/' + id;
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
