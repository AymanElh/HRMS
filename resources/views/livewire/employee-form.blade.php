<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-700 p-6">
        <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white" required>
                @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white" required>
                @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Profile Picture -->
            <div class="mb-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-300">Profile Picture</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white">
                </div>
                @error('profile_picture') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label for="department" class="block text-sm font-medium text-gray-300">Department</label>
                <select name="department" wire:model="selectedDepartment" wire:change="jobsByDepartment($event.target.value)" id="department" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department) 
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('selectedDepartment') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Position -->
            <div class="mb-4">
                <label for="position" class="block text-sm font-medium text-gray-300">Position</label>
                <select name="position" id="position" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white" required>
                    <option value="">Select Position</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                    @endforeach
                </select>
                @error('position') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Salary -->
            <div class="mb-4">
                <label for="salary" class="block text-sm font-medium text-gray-300">Salary</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">$</span>
                    <input type="number" name="salary" id="salary" class="w-full pl-8 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white" placeholder="0.00" required>
                </div>
                @error('salary') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Save Employee
                </button>
            </div>
        </form>
    </div>
</div>