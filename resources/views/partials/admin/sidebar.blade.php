<aside class="fixed top-0 left-0 w-72 h-screen bg-white shadow-[8px_0_32px_0_rgba(31,38,135,0.15)]">
    <nav class="h-full flex flex-col p-4" id="sidebarNav">
        <div class="mb-8">
            <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('products') }}"
                class="flex items-center gap-3 px-2">
                <div class="p-2.5 rounded-xl gradient-primary shadow-lg shadow-purple-500/20">
                    <x-zondicon-view-carousel class="h-6 w-6 text-white" />
                </div>
                <span class="text-xl font-bold text-gray-800">
                    Olshop
                </span>
            </a>
        </div>

        <div class="flex-1 space-y-1 overflow-y-auto custom-scrollbar">
            <div class="mb-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</div>

            <div id="menuItems">
                <!-- Menu items will be populated by JavaScript -->
            </div>
        </div>
    </nav>
</aside>

<script>
    // Define all routes at the top
    const routes = {
        dashboard: '{{ route('admin.dashboard') }}',
        clothes: '{{ route('admin.clothes.index') }}',
        categories: '{{ route('admin.categories.index') }}',
        backup: '{{ route('admin.backup.index') }}',
        products: '{{ route('products') }}',
        adminTransactions: '{{ route('admin.transactions.index') }}',
        userTransactions: '{{ route('user.transactions.index') }}'
    };

    // Add this helper function at the top of your script
    function getActiveClasses(routePath) {
        const currentPath = window.location.pathname;
        console.log('Current Path:', currentPath);
        console.log('Route Path:', routePath);

        // Extract path from full URL if needed
        const urlPath = new URL(routePath, window.location.origin).pathname;
        console.log('URL Path:', urlPath);

        // Remove trailing slashes and normalize both paths
        const normalizedCurrentPath = currentPath.replace(/\/$/, '');
        const normalizedRoutePath = urlPath.replace(/\/$/, '');

        const isActive = normalizedCurrentPath === normalizedRoutePath;
        console.log('Is Active:', isActive);

        return {
            link: isActive ? 'bg-gradient-to-r from-purple-500/10 to-red-400/10 shadow-sm' : 'hover:bg-gray-50',
            icon: isActive ?
                'bg-gradient-to-br from-purple-500 to-red-400 text-white shadow-lg shadow-purple-500/20' :
                'bg-white text-gray-400 border border-gray-100 group-hover:border-purple-200 group-hover:text-purple-500',
            text: isActive ?
                'bg-gradient-to-r from-purple-500 to-red-400 bg-clip-text text-transparent font-semibold' :
                'text-gray-600 group-hover:text-gray-900',
            dots: isActive ?
                `<div class="ml-auto flex items-center gap-1">
                    <div class="w-1 h-1 rounded-full bg-purple-500"></div>
                    <div class="w-1 h-1 rounded-full bg-red-400"></div>
                   </div>` :
                ''
        };
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        try {
            // Fetch user data using the token
            const response = await fetch('/api/user', {
                headers: {
                    // 'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'include' // Add this line
            });

            if (!response.ok) {
                throw new Error('Failed to fetch user data');
            }

            const userData = await response.json();
            const menuItems = document.getElementById('menuItems');

            // Show the sidebar once we confirm authentication
            document.getElementById('sidebarNav').style.display = 'flex';

            if (userData.role === 'admin') {
                const dashboardClasses = getActiveClasses(routes.dashboard);
                const clothesClasses = getActiveClasses(routes.clothes);
                const categoriesClasses = getActiveClasses(routes.categories);
                const backupClasses = getActiveClasses(routes.backup);

                menuItems.innerHTML = `
                    <a href="${routes.dashboard}" class="group block px-4 py-3 rounded-xl ${dashboardClasses.link}">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg ${dashboardClasses.icon}">
                                <x-zondicon-home class="h-5 w-5" />
                            </div>
                            <span class="${dashboardClasses.text}">Dashboard</span>
                            ${dashboardClasses.dots}
                        </div>
                    </a>
                    <a href="${routes.clothes}" class="group block px-4 py-3 rounded-xl ${clothesClasses.link}">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg ${clothesClasses.icon}">
                                <x-zondicon-apparel class="h-5 w-5" />
                            </div>
                            <span class="${clothesClasses.text}">Manage Clothes</span>
                            ${clothesClasses.dots}
                        </div>
                    </a>
                    <a href="${routes.categories}" class="group block px-4 py-3 rounded-xl ${categoriesClasses.link}">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg ${categoriesClasses.icon}">
                                <x-zondicon-tag class="h-5 w-5" />
                            </div>
                            <span class="${categoriesClasses.text}">Manage Categories</span>
                            ${categoriesClasses.dots}
                        </div>
                    </a>
                    <div class="mb-4 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6">System</div>
                    <a href="${routes.backup}" class="group block px-4 py-3 rounded-xl ${backupClasses.link}">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg ${backupClasses.icon}">
                                <i class="fas fa-server h-5 w-5"></i>
                            </div>
                            <span class="${backupClasses.text}">Backup Management</span>
                            ${backupClasses.dots}
                        </div>
                    </a>
                `;
            }

            // Common menu items for all users
            const productsClasses = getActiveClasses(routes.products);
            const transactionsClasses = getActiveClasses(userData.role === 'admin' ? routes
                .adminTransactions : routes.userTransactions);

            menuItems.innerHTML += `
                <a href="${routes.products}" class="group block px-4 py-3 rounded-xl ${productsClasses.link}">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg ${productsClasses.icon}">
                            <x-zondicon-search class="h-5 w-5" />
                        </div>
                        <span class="${productsClasses.text}">Find Products</span>
                        ${productsClasses.dots}
                    </div>
                </a>
                <a href="${userData.role === 'admin' ? routes.adminTransactions : routes.userTransactions}" 
                   class="group block px-4 py-3 rounded-xl ${transactionsClasses.link}">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg ${transactionsClasses.icon}">
                            <x-zondicon-currency-dollar class="h-5 w-5" />
                        </div>
                        <span class="${transactionsClasses.text}">Transactions</span>
                        ${transactionsClasses.dots}
                    </div>
                </a>
            `;

        } catch (error) {
            console.error('Auth check failed:', error);
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    });
</script>
