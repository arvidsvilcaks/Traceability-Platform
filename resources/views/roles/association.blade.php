<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <h1 class="flex justify-center text-lg font-semibold mb-4 mt-6">List of Registered Beekeepers, Laboratory employees, Wholesalers, Packaging company employees</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">   
                <tr>
                    <th class="px-6 py-3 text-center">Name</th>
                    <th class="px-6 py-3 text-center">Surname</th>
                    <th class="px-6 py-3 text-center">Company</th>
                    <th class="px-6 py-3 text-center">Role</th>
                    <th class="px-6 py-3 text-center">Country</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersAssociation as $userAssociation)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                        <td class="px-6 py-4 text-center">{{ $userAssociation->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $userAssociation->surname }}</td>
                        <td class="px-6 py-4 text-center">{{ $userAssociation->company }}</td>
                        <td class="px-6 py-4 text-center">{{ $userAssociation->role }}</td>
                        <td class="px-6 py-4 text-center">{{ $userAssociation->country }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($userAssociation->is_enabled)
                                <span class="text-green-600 font-bold">Enabled</span>
                            @else
                                <span class="text-red-600 font-bold">Disabled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('users.update_status', $userAssociation->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @if ($userAssociation->is_enabled)
                                    <button type="submit" name="is_enabled" value="0" class="px-4 py-2 bg-gray-500 text-white rounded">Disable</button>
                                @else
                                    <button type="submit" name="is_enabled" value="1" class="px-4 py-2 bg-gray-500 text-white rounded">Enable</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
