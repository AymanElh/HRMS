<div class="p-6 bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-white">
        {{ $userRole === 'hr' ? 'HR' : 'Manager' }} Vacation Approvals
    </h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Dates</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Days</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Reason</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($pendingRequests as $request)
                    <tr>
                        <td class="px-6 py-4 text-gray-200">
                            {{ $request->employee->full_name }}
                        </td>
                        <td class="px-6 py-4 text-gray-200">
                            {{ \Carbon\Carbon::parse($request->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-200">
                            {{ $request->total_days }}
                        </td>
                        <td class="px-6 py-4 text-gray-200">
                            {{ $request->reason }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $request->status === 'manager_approved' ? 'bg-green-900 text-green-200' : 
                                   ($request->status === 'pending' ? 'bg-yellow-900 text-yellow-200' : 
                                   'bg-red-900 text-red-200') }}">
                                @if($userRole === 'hr')
                                    {{ $request->manager_validated_at ? 'Manager Approved' : 'Pending Manager' }}
                                @else
                                    {{ ucfirst($request->status) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-200 space-x-2">
                            @if($userRole === 'manager' || ($userRole === 'hr' && $request->manager_validated_at))
                                <button wire:click="approve({{ $request->id }})" 
                                        class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Approve
                                </button>
                                <button wire:click="openRejectModal({{ $request->id }})" 
                                        class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Reject
                                </button>
                            @else
                                <span class="text-gray-400">Awaiting Manager Approval</span>
                            @endif
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

    <!-- Reject Modal -->
    <div x-data="{ open: @entangle('showRejectModal') }"
         x-show="open"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-white mb-4">Reject Vacation Request</h3>
                    <textarea wire:model.defer="rejectReason"
                              class="w-full bg-gray-700 text-white rounded-md border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-500"
                              rows="3"
                              placeholder="Enter reason for rejection..."></textarea>
                </div>
                <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="reject" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm Reject
                    </button>
                    <button @click="open = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>