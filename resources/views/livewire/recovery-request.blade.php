<div class="p-6 bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-white">Recovery Days Request</h2>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-900 text-green-200 rounded-md">
            {{ session('message') }}
        </div>
    @elseif(session()->has('error'))
        <div class="mb-4 px-4 py-2 bg-red-900 text-green-200 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submitRequest" class="space-y-6">
        <!-- Date Range -->
        <div class="flex justify-between gap-3">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-300">Start Date</label>
                <input type="date" 
                    wire:model="start_date"
                    id="start_date"
                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500">
                @error('start_date') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-300">End Date</label>
                <input type="date" 
                    wire:model="end_date"
                    id="end_date"
                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500">
                @error('end_date') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Request
            </button>
        </div>
    </form>

    <!-- Recovery Requests List -->
    <div class="mt-10">
        <h3 class="text-xl font-bold mb-4 text-white">My Recovery Requests</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($recoveryRequests as $request)
                        <tr>
                            <td class="px-6 py-4 text-gray-200">
                                {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->days }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->status === 'approved' ? 'bg-green-900 text-green-200' : 
                                       ($request->status === 'rejected' ? 'bg-red-900 text-red-200' : 
                                       'bg-yellow-900 text-yellow-200') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                No recovery requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>