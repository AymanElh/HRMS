<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Career') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 shadow-lg rounded-lg p-6">

            <!-- Employee Header -->
            <div class="flex items-center mb-8">
                <!-- Profile Picture -->
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-700 flex items-center justify-center mr-6">
                    @if($employee->user->profile_photo_path)
                        <img src="{{ Storage::url($employee->user->profile_photo_path) }}"
                             alt="{{ $employee->user->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl text-white">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <!-- Basic Info -->
                <div>
                    <h3 class="text-2xl font-bold text-white">{{ $employee->user->name }}</h3>
                    <h4 class="text-l font-bold text-white">{{ $employee->user->email }}</h4>
                    <h5>{{ $employee->user->phone_number ?? '212638292829' }}</h5>
                </div>
            </div>

            <!-- Horizontal Timeline -->
            @php
                $contracts = $employee->contracts;
                // {{ dd($contracts); }}
            @endphp

            <div class="flex items-center space-x-4 overflow-x-auto mb-10">
                @foreach($contracts as $index => $contract)
                    <div class="relative flex flex-col items-center">
                        <!-- Step Circle -->
                        <div class="w-10 h-10 flex items-center justify-center rounded-full 
                                    {{ $loop->last ? 'bg-blue-600' : 'bg-blue-500' }} text-white font-semibold">
                            {{ $index + 1 }}
                        </div>
                        <!-- Date / Info -->
                        <div class="mt-2 text-center">
                            <p class="text-sm text-gray-300">
                                {{ \Carbon\Carbon::parse($contract->startDate)->format('d/m/Y') }}
                            </p>
                            <p class="text-sm text-gray-100">
                                {{ $contract->type->type ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-green-400">
                                {{ ucfirst($contract->status ?? 'Active') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            @php
                $currentContract = $contracts->last();
                // {{ dd($currentContract); }}
            @endphp

            @if($currentContract)
                <div class="bg-gray-700 p-6 rounded-md">
                    <h4 class="text-xl font-bold text-white mb-4">
                        Contract Details ({{ $currentContract->type->type ?? 'N/A' }})
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h3.5a1 1 0 010 2H6v14h12V7h-3.5a1 1 0 010-2H18a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                            </svg>
                            <span>Start Date: {{ \Carbon\Carbon::parse($currentContract->startDate)->toFormattedDayDateString() }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-6 8h6m-6 4h6M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z"/>
                            </svg>
                            <span>End Date: 
                                {{ $currentContract->endDate ? \Carbon\Carbon::parse($currentContract->endDate)->toFormattedDayDateString() : 'Indefinite' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.66 0-3 .895-3 2 0 1.105 1.34 2 3 2s3 .895 3 2c0 1.105-1.34 2-3 2m0-8c1.66 0 3 .895 3 2 0 1.105-1.34 2-3 2s-3 .895-3 2c0 1.105 1.34 2 3 2m0-8c1.66 0 3 .895 3 2 0 1.105-1.34 2-3 2s-3 .895-3 2"/>
                            </svg>
                            <span>Salary: ${{ number_format($currentContract->salary, 2) }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h6m2 8V7a2 2 0 00-2-2h-5.172a2 2 0 01-1.414-.586L9 2.414A2 2 0 007.586 2H5a2 2 0 00-2 2v11a2 2 0 002 2h4"/>
                            </svg>
                            <span>Status: {{ $currentContract->status }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Employees
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
