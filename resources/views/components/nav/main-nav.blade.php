<nav class="fixed w-full bg-gradient-to-r from-white/60 via-purple-50/60 to-white/60 backdrop-blur-xl shadow-lg z-50 transition-all duration-500"
    x-data="{ scrolled: false, mobileMenu: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'py-6': !scrolled, 'py-4 from-white/80 via-purple-50/80 to-white/80': scrolled }">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex justify-between items-center">
            <a href="/"
                class="text-2xl lg:text-3xl font-bold tracking-tighter text-transparent bg-clip-text 
                bg-gradient-to-r from-gray-900 via-indigo-900 to-gray-900 hover:scale-105 transition-all duration-500
                relative before:content-[''] before:absolute before:-bottom-1 before:left-0 before:w-full before:h-px
                before:bg-gradient-to-r before:from-transparent before:via-indigo-600 before:to-transparent">
                Prestige Couture
            </a>

            <button class="lg:hidden relative group" @click="mobileMenu = !mobileMenu">
                <div class="p-2 hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-bars text-xl text-gray-900"></i>
                </div>
                <div
                    class="absolute inset-0 bg-black/5 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300">
                </div>
            </button>

            <div class="hidden lg:flex items-center gap-8">
                <x-nav.nav-link href="#home">Home</x-nav.nav-link>
                <x-nav.nav-link href="#about">About</x-nav.nav-link>
                <x-nav.nav-link href="#products">Products</x-nav.nav-link>
                <x-nav.nav-link href="#faq">FAQ</x-nav.nav-link>
                <x-nav.nav-link href="/cart">Cart</x-nav.nav-link>
                <a href="/login"
                    class="group relative px-5 py-2 rounded-full overflow-hidden transition-all duration-500 bg-gradient-to-r from-purple-500 to-rose-400">
                    <span class="relative z-10 font-medium text-white">
                        Login
                    </span> 
                </a>
            </div>
        </div>
    </div>

    <div class="lg:hidden overflow-hidden transition-all duration-500 ease-in-out" x-show="mobileMenu"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4">
        <div class="px-4 py-3 space-y-3 bg-white/90 backdrop-blur-lg">
            <x-nav.nav-link href="#home">Home</x-nav.nav-link>
            <x-nav.nav-link href="#about">About</x-nav.nav-link>
            <x-nav.nav-link href="#products">Products</x-nav.nav-link>
            <x-nav.nav-link href="#faq">FAQ</x-nav.nav-link>
            <x-nav.nav-link href="/cart">Cart</x-nav.nav-link>
            <a href="/login" class="btn-primary block">Login</a>
        </div>
    </div>
</nav>
