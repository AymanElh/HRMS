<div class="p-6 bg-gray-800 rounded-lg shadow-lg mt-8">
    <!-- Header with Title and Add Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">Extra Work Days Management</h2>
        {{-- @if(auth()->user()->hasRole('hr')) --}}
            <button 
                wire:click="$set('showModal', true)" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Extra Days
            </button>
        {{-- @endif --}}
    </div>

    <!-- Balance Card -->
    <div class="bg-gray-700 rounded-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-500 bg-opacity-25">
                    <svg class="h-8 w-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-400">Current Balance</p>
                    <p class="text-2xl font-bold text-white">
                        {{ $balance->current_balance }} days
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400">Last Updated</p>
                <p class="text-sm text-gray-300">
                    {{ $employee->extra_days_updated_at ? $employee->extra_days_updated_at->diffForHumans() : 'Never' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-md bg-green-500 bg-opacity-10 border border-green-500 text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <!-- Modal remains the same -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50" 
         style="display: none;">
        <!-- ... existing modal code ... -->
        <form wire:submit.prevent="addExtraDays">
            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium leading-6 text-white mb-4">Add Extra Work Days</h3>
                <div class="mb-4">
                    <label for="days" class="block text-sm font-medium text-gray-300">Number of Days</label>
                    <input type="number" wire:model="extraDaysToAdd" name="balance" id="days" min="0.5" step="0.5" 
                        class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                </button>
                <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>