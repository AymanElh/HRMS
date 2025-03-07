<div>
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-900 text-green-200 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <!-- Pending Requests Table -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4 text-white">Pending Requests</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($pendingRequests as $request)
                        <tr>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->employee->user->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->days }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900 text-yellow-200">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-200 space-x-2">
                                <button wire:click="approve({{ $request->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Approve
                                </button>
                                <button wire:click="openRejectModal({{ $request->id }})"
                                        class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Reject
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No pending requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- History Table -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4 text-white">Request History</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Processed At</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($processedRequests as $request)
                        <tr>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->employee->user->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ Carbon\Carbon::parse($request->start_date)->format('M d') }} - 
                                {{ Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->days }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->status === 'approved' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-200">
                                {{ $request->hr_validated_at ? $request->hr_validated_at->format('M d, Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                                No processed requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reject Modal -->
    <div x-data="{ show: @entangle('showRejectModal') }"
         x-show="show"
         class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50"
         style="display: none;">
        <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium text-white mb-4">Reject Recovery Request</h3>
            <div class="mb-4">
                <label for="rejectReason" class="block text-sm font-medium text-gray-300">Reason for Rejection</label>
                <textarea wire:model="rejectReason"
                        id="rejectReason"
                        rows="3"
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white"></textarea>
                @error('rejectReason') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end space-x-3">
                <button wire:click="$set('showRejectModal', false)"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Cancel
                </button>
                <button wire:click="reject"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Reject
                </button>
            </div>
        </div>
    </div>
</div>