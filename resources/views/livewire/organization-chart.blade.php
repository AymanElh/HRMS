<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Organization Chart</h2>

    <div class="overflow-auto">
        <div class="min-w-full flex flex-col items-center space-y-8">
            <!-- CEO Level -->
            <div class="flex flex-col items-center">
                <div class="p-4 bg-indigo-100 dark:bg-indigo-900 rounded-lg shadow">
                    <div class="text-center">
                        <div class="text-lg font-semibold text-indigo-900 dark:text-indigo-100">CEO</div>
                        <div class="text-sm text-indigo-700 dark:text-indigo-300">Ayman Elh</div>
                    </div>
                </div>
                <div class="w-px h-8 bg-indigo-300 dark:bg-indigo-700"></div>
            </div>

            <!-- Departments Level -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($hierarchy as $department)
                    <div class="flex flex-col items-center">
                        <!-- Department Header -->
                        <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg shadow mb-4 w-64">
                            <div class="text-center">
                                <div class="text-lg font-semibold text-blue-900 dark:text-blue-100">
                                    {{ $department['name'] }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Department Employees -->
                        <div class="space-y-4">
                            @foreach($department['employees'] as $employee)
                                <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg shadow w-56">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $employee['image'] }}" 
                                             alt="{{ $employee['name'] }}" 
                                             class="w-10 h-10 rounded-full">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $employee['name'] }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $employee['position'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>