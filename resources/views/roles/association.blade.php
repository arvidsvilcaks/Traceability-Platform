<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <h1 class="flex bg-slate-100 justify-center text-2xl mb-4">List of registered Users</h1>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">   
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">Name</th>
                    <th scope="col" class="px-6 py-3 text-center">Surname</th>
                    <th scope="col" class="px-6 py-3 text-center">Certifications</th>
                    <th scope="col" class="px-6 py-3 text-center">Produced products</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="px-6 py-4 text-center">Juris</td>
                    <td class="px-6 py-4 text-center">Berzins</td>
                    <td class="px-6 py-4 text-center">
                        <a href="#" class="font-medium text-blue-600 hover:underline">certificate.pdf</a>
                    </td>
                    <td class="px-6 py-4 text-center">Wildflower honey</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>
