<div class="px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">My Dashboard</h2>
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Dashboard
                </a>
            </li>
            @can('Manage Departments')
                <li>
                    <a href="{{ route('departments.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Departments
                    </a>
                </li>
            @endcan
            @can('Manage Employees')
            
                <li>
                    <a href="{{ route('employees.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Employees
                    </a>
                </li>
            @endcan
            @can('Manage Contracts')
                <li>
                    <a href="{{ route('contracts.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Contracts
                    </a>
                </li>
                <li>
                    <a href="{{ route('formations.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Formations
                    </a>
                </li>
            @endcan
            @can('Manage Jobs')
                <li>
                    <a href="{{ route('jobs.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Jobs
                    </a>
                </li>
            @endcan
            @can('Manage Profile')
                <li>
                    <a href="{{ route('employees.profile', auth()->user()) }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Profile
                    </a>
                </li>
            @endcan
            <li>
                <a href="" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Vacation Request
                </a>
            </li>
        </ul>
    </nav>
</div>
