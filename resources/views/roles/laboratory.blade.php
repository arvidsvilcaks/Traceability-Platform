<x-app-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
        <h1 class="flex justify-center text-lg font-semibold mb-4">
            Provide Honey Analysis Results
        </h1>

        <table class="w-full text-sm text-center text-gray-500 border-separate border border-gray-200"">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 border">Action</th>
                    <th scope="col" class="px-6 py-3 border">File</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-6 py-4 border">
                        @if(isset($honeyInfo))
                            <form action="{{ route('analysis.updateAnalysis', ['id' => $honeyInfo->id]) }}" 
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
                    <td class="px-6 py-4 text-center border">
                        @if(isset($honeyInfo) && $honeyInfo->add_analysis_results)
                            <p class="text-gray-700">
                                Uploaded file: 
                                <a href="{{ asset('storage/' . $honeyInfo->add_analysis_results) }}" 
                                class="text-blue-500 underline" target="_blank">
                                    View File
                                </a>
                            </p>
                            <form action="{{ route('analysis.deleteAnalysis', ['id' => $honeyInfo->id]) }}" method="POST">
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
</x-app-layout>
