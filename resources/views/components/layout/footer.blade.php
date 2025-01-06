<footer class="relative overflow-hidden bg-gradient-to-b from-gray-900 via-indigo-950 to-black text-gray-400 py-16">
    <div class="absolute inset-0 bg-[url('/images/noise.png')] opacity-5"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 via-transparent to-pink-500/5"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-purple-100 to-white
                    relative before:content-[''] before:absolute before:-bottom-2 before:left-0
                    before:w-12 before:h-0.5 before:bg-gradient-to-r before:from-purple-400 before:to-transparent">
                    Prestige Couture
                </h2>
                <p class="text-gray-400 leading-relaxed">
                    Elevating fashion to an art form, creating timeless pieces for the distinguished individual.
                </p>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white">Quick Links</h3>
                <ul class="space-y-2">
                    <x-nav.footer-link href="#about">About Us</x-nav.footer-link>
                    <x-nav.footer-link href="#products">Collections</x-nav.footer-link>
                    <x-nav.footer-link href="#services">Services</x-nav.footer-link>
                </ul>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-white">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fas fa-envelope w-5"></i>
                        contact@prestigecouture.com
                    </li>
                    <li class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fas fa-phone w-5"></i>
                        +1 (555) 123-4567
                    </li>
                </ul>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-200">
                    Newsletter
                </h3>
                <form class="space-y-2">
                    <input type="email" placeholder="Enter your email" 
                        class="w-full px-4 py-2 bg-white/5 border border-purple-800/30 rounded-lg
                        focus:outline-none focus:border-purple-500/50 text-white placeholder-gray-500
                        transition-all duration-300 focus:shadow-[0_0_20px_rgba(168,85,247,0.15)]">
                    <button class="w-full px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg
                        hover:from-purple-500 hover:to-pink-500 transition-all duration-300
                        hover:shadow-[0_0_25px_rgba(168,85,247,0.3)]">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-12 pt-8 border-t border-purple-800/20 text-center">
            <p class="text-gray-500">&copy; 2024 Prestige Couture. All rights reserved.</p>
        </div>
    </div>
</footer>
