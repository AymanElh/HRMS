<div class="px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">My Dashboard</h2>
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('departments.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Departments
                </a>
            </li>
            <li>
                <a href="" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Employees
                </a>
            </li>
            <li>
                <a href="" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Contracts
                </a>
            </li>
            <li>
                <a href="{{ route('formations.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                    Formations
                </a>
            </li>
        </ul>
    </nav>
</div>
