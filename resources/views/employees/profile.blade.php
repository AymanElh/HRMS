<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Employee Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 relative">
                    <div class="flex items-center space-x-6">
                        <!-- Profile Picture -->
                        @if($employee->user->profile_photo_path)
                            <img class="h-32 w-32 rounded-full object-cover" 
                            src="{{ Storage::url($employee->user->profile_photo_path) }}" 
                            alt="{{ $employee->user->name }}">
                        @else
                            <div class="flex-shrink-0">
                                <div class="h-32 w-32 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <span class="text-4xl font-bold text-white">
                                        {{strtoupper(substr($employee->user->name, 0, 1))}}
                                    </span>
                                </div>
                            </div>
                        @endif
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{$employee->user->name}}</h3>
                            <p class="text-gray-400">Senior Developer</p>
                            <p class="text-gray-400">{{$employee->department->name}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-800 p-6 rounded-lg shadow">
                    <div class="text-gray-400">Total Contracts</div>
                    <div class="text-2xl font-bold text-white">{{ $stats['totalContracts'] }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow">
                    <div class="text-gray-400">Active Formations</div>
                    <div class="text-2xl font-bold text-white">{{ $stats['formations'] }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-lg shadow">
                    <div class="text-gray-400">Period of Service</div>
                    <div class="text-2xl font-bold text-white">{{$employee->created_at->diffForHumans(now()) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-white mb-4">Personal Information</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Email</span>
                                <span class="text-white">{{ $employee->user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Phone</span>
                                <span class="text-white">{{ $employee->phoneNumber ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Address</span>
                                <span class="text-white">123 Main St, City, Country</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Role</span>
                                <span class="text-white">{{ $employee->user->getRoleNames()->implode(', ') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-semibold text-white mb-4">Professional Information</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Department</span>
                                <span class="text-white">{{ $employee->department->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Position</span>
                                <span class="text-white">{{ $employee->position->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Hire Date</span>
                                <span class="text-white">{{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Contracts History -->
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg md:col-span-2">
                <div class="p-6">
                    <h4 class="text-xl font-semibold text-white mb-4">Career Timeline</h4>
                    
                    <!-- Horizontal Timeline -->
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute w-full border-t-2 border-gray-600 top-1/2 transform -translate-y-1/2"></div>
                        
                        <!-- Timeline Items -->
                        <div class="flex items-center justify-between relative">
                            <!-- CDI Contract -->
                            @foreach($employee->contracts as $contract)
                                <div class="relative flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center z-10">
                                        <span class="text-white font-bold">1</span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <p class="text-sm text-gray-300">{{ $contract->startDate }}</p>
                                        <p class="text-sm font-medium text-white">{{ $contract->type->type }}</p>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">
                                            Active
                                        </span>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <!-- Current Contract Details -->
                    <div class="bg-gray-700 p-6 rounded-lg mt-8">
                        <h5 class="text-lg font-semibold text-white mb-4">Current Contract Details</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-400">Contract Type</p>
                                <p class="text-white">{{ $stats['current_contract']->type->type }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Start Date</p>
                                <p class="text-white">{{ $stats['current_contract']->startDate }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Duration</p>
                                <p class="text-white">Unlimited</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Status</p>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">
                                    {{-- {{ $stats['current_contract']->endDate->diffInDays(now()) < 0 ? 'Finished' : 'Active' }} --}}
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>