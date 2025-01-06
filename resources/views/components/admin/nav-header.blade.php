<header class="bg-white rounded-2xl mb-6 backdrop-blur-xl shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
    <div class="flex justify-between items-center p-5">
        <h1 class="text-2xl font-bold flex items-center gap-3">
            <span class="w-1.5 h-8 gradient-primary rounded-full"></span>
            <span class="text-gray-800">
                {{ $title ?? 'Dashboard' }}
            </span>
        </h1>

        <div class="flex items-center gap-6">
            <div class="relative">
                <button class="p-2 hover:bg-gray-50 rounded-xl transition-all">
                    <x-zondicon-notifications class="w-6 h-6 text-gray-600" />
                    <span class="absolute top-0 right-0 w-2 h-2 rounded-full gradient-primary"></span>
                </button>
            </div>
            <a href="{{ url('/cart') }}" class="relative p-2 hover:bg-gray-50 rounded-xl transition-all">
                <x-zondicon-shopping-cart class="w-6 h-6 text-gray-600" />
                <span class="absolute top-0 right-0 w-2 h-2 rounded-full gradient-primary"></span>
            </a>
            <div class="h-6 w-px bg-gray-200"></div>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="group px-4 py-2 rounded-xl hover:bg-gray-50 text-gray-600 font-medium transition-all flex items-center gap-2">
                    <span>Logout</span>
                    <x-zondicon-stand-by class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    document.getElementById('logoutForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const response = await fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
            });

            const data = await response.json();

            if (data.success) {
                // Remove token from localStorage
                localStorage.removeItem('token');

                // Redirect to login page
                window.location.replace(data.redirect);
            } else {
                alert(data.message || 'Logout failed. Please try again.');
            }
        } catch (error) {
            console.error('Logout error:', error);
            alert('An error occurred during logout. Please try again.');
        }
    });
</script>
