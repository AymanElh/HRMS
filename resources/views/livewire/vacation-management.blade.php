<div class="p-6 bg-gray-800 rounded-lg shadow-lg">
    <!-- Vacation Balance Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 text-white">Vacation Balance</h2>
        <div class="bg-gray-700 p-4 rounded-lg">
            <p class="text-lg text-gray-200">
                Available Days: 
                <span class="font-bold text-indigo-400">
                    {{-- {{ number_format($vacationBalance->available_days, 1) }} --}}
                    20
                </span>
            </p>
            <p class="text-sm text-gray-400">
                Years of Service: {{ $employee->years_of_service }}
            </p>
        </div>
    </div>

    <!-- Request Form Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 text-white">Request Vacation</h2>
        
        @if (session()->has('message'))
            <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Start Date</label>
                    <input type="date" 
                           wire:model="start_date"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500">
                    @error('state_date') 
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">End Date</label>
                    <input type="date" 
                           wire:model="end_date"
                           class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500">
                    @error('end_date') 
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if($totalDays > 0)
                <div class="bg-gray-700 p-3 rounded text-gray-200">
                    Total Working Days: <span class="font-bold text-indigo-400">{{ $totalDays }}</span>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-300">Reason</label>
                <textarea wire:model="reason"
                          rows="3"
                          class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Enter your vacation reason..."></textarea>
                @error('reason') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Submit Request
            </button>
        </form>
    </div>

    <!-- Pending Requests Section -->
    <div>
        <h2 class="text-2xl font-bold mb-4 text-white">My Requests</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Submitted</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($pendingRequests as $request)
                        <tr>
                            <td class="px-6 py-4 text-gray-200">
                                {{ \Carbon\Carbon::parse($request->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse( $request->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">{{ $request->total_days }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->status === 'approved' ? 'bg-green-900 text-green-200' : 
                                       ($request->status === 'rejected' ? 'bg-red-900 text-red-200' : 
                                       'bg-yellow-900 text-yellow-200') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                No vacation requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>