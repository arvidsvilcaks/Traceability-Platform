<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Traceability platform') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-4">Product List</h1>

        @if(auth()->user()->role == 'Beekeeping association')
            <div class="flex justify-center mb-4">
                <button onclick="showModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full">
                    Add New Product
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
                @foreach($honeyInfo as $honey)
                    <tr>
                        <td class="px-6 py-4 border">{{ $honey->name }}</td>
                        <td class="px-6 py-4 border">
                            @if(auth()->user()->role == 'Beekeeping association')
                                <div>
                                    <p><strong>Beekeeper:</strong> {{ $honey->beekeeper->name ?? 'None' }}</p>
                                    <p><strong>Laboratory Employee:</strong> {{ $honey->laboratoryEmployee->name ?? 'None' }}</p>
                                    <p><strong>Wholesaler:</strong> {{ $honey->wholesaler->name ?? 'None' }}</p>
                                    <p><strong>Packaging Company:</strong> {{ $honey->packagingCompany->name ?? 'None' }}</p>
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
                                @elseif(auth()->user()->role == 'Administrator')
                                <div>
                                    <p><strong>Beekeeper:</strong> {{ $honey->beekeeper->name ?? 'None' }}</p>
                                    <p><strong>Laboratory Employee:</strong> {{ $honey->laboratoryEmployee->name ?? 'None' }}</p>
                                    <p><strong>Wholesaler:</strong> {{ $honey->wholesaler->name ?? 'None' }}</p>
                                    <p><strong>Packaging Company:</strong> {{ $honey->packagingCompany->name ?? 'None' }}</p>
                                </div>
                            @elseif(auth()->user()->role == 'Beekeeper' && $honey->beekeeper_id == auth()->user()->id)
                                <a href="{{ route('beekeeper.index', ['product_id' => $honey->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Beekeeper Data
                                </a>
                            @elseif(auth()->user()->role == 'Laboratory employee' && $honey->laboratory_id == auth()->user()->id)
                                <a href="{{ route('laboratory.index', ['product_id' => $honey->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Lab Data
                                </a>
                            @elseif(auth()->user()->role == 'Wholesaler' && $honey->wholesaler_id == auth()->user()->id)
                                <a href="{{ route('wholesaler.index', ['product_id' => $honey->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Wholesaler Data
                                </a>
                            @elseif(auth()->user()->role == 'Packaging company' && $honey->packaging_id == auth()->user()->id)
                                <a href="{{ route('packaging.index', ['product_id' => $honey->id]) }}" 
                                class="bg-gray-500 text-white rounded-full px-4 py-2 hover:bg-gray-700">
                                    View Packaging Data
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(auth()->user()->role == 'Beekeeping association')
    <div id="addProductModal" class="fixed inset-0 flex items-center justify-center hidden">
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
        document.getElementById('addProductModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('addProductModal').classList.add('hidden');
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
    </script>
</x-app-layout>
