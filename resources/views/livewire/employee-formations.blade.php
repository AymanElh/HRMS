<div class="mt-8">
    <!-- Formations Section -->
    <div class="bg-gray-800 shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Formations & Training</h2>
            
            <button wire:click="openModal" 
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Assign Formation
            </button>
        </div>

        <!-- Formations List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Formation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($employeeFormations as $formation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ $formation->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ \Carbon\Carbon::parse($formation->pivot->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                {{ \Carbon\Carbon::parse($formation->pivot->end_date)->format('d/m/Y')}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $formation->pivot->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                       ($formation->pivot->status === 'in_progress' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                    Pending
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                No formations assigned yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div x-data="{ show: @entangle('showModal') }"
         x-show="show"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                 @click.away="show = false">
                
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="assignFormation">
                    <!-- Formation Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300">Formation</label>
                        <select wire:model="selectedFormation" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                            <option value="">Select Formation</option>
                            @foreach($formations as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->title }}</option>
                            @endforeach
                        </select>
                        @error('selectedFormation') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300">Start Date</label>
                        <input type="date" wire:model="startDate" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                        @error('startDate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300">End Date</label>
                        <input type="date" wire:model="endDate" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                        @error('endDate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300">Status</label>
                        <select wire:model="status" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5 sm:mt-6">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                            Assign Formation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

