<div class="space-y-6">
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 rounded-md shadow-lg transform transition-all duration-300 ease-in-out">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Add Department Button -->
    <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-300 ease-in-out flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add Department
    </button>

    <!-- Departments Table -->
    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Departments
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach ($departments as $department)
                    <tr class="hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $department->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $department->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <button wire:click="edit({{ $department->id }})"
                                        class="group flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all duration-200 ease-in-out focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button wire:click="delete({{ $department->id }})"
                                        class="group flex items-center px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-all duration-200 ease-in-out focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
            <div class="bg-gray-800 rounded-lg shadow-xl w-full max-w-md border border-gray-700 transform transition-all duration-300 ease-in-out">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white">{{ $isEdit ? 'Edit Department' : 'Add Department' }}</h2>
                        <button wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-white focus:outline-none transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Department Name</label>
                            <input type="text" id="name" wire:model="name" placeholder="Department Name"
                                   class="bg-gray-700 border-gray-600 text-white placeholder-gray-400 rounded-md shadow-sm w-full px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                            <textarea id="description" wire:model="description" placeholder="Description" rows="4"
                                      class="bg-gray-700 border-gray-600 text-white placeholder-gray-400 rounded-md shadow-sm w-full px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            @error('description') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button wire:click="$set('isOpen', false)" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2.5 rounded-md transition-colors duration-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            Cancel
                        </button>
                        <button wire:click="store"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-md transition-colors duration-200 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            {{ $isEdit ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
