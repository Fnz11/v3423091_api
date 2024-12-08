<div class="w-[25rem] min-h-screen p-4">
    <nav class="h-full flex flex-col justify-between">
        <ul class="mb-5">
            <li class="w-full flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="text-xl font-semibold mx-auto flex items-center justify-center gap-1">
                    <x-zondicon-view-carousel class="h-6 w-6 rotate-12" /> Olshop
                </a>
            </li>
        </ul>
        <ul class="space-y-2 h-ful">
            <x-nav.side-link href="admin.dashboard">
                <x-slot name="icon">
                    <x-zondicon-home class="h-4 w-4" />
                </x-slot>
                Dashboard
            </x-nav.side-link>

            <x-nav.side-link href="admin.clothes.index">
                <x-slot name="icon">
                    <x-zondicon-apparel class="h-4 w-4" />
                </x-slot>
                Manage Clothes
            </x-nav.side-link>
            <x-nav.side-link href="admin.categories.index">
                <x-slot name="icon">
                    <x-zondicon-apparel class="h-4 w-4" />
                </x-slot>
                Manage Categories
            </x-nav.side-link>
        </ul>
        <ul class="mt-auto">
            <li>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="font-bold bg-red-400 shadow-2xl shadow-slate-300 w-full flex items-center gap-2 text-white p-2 rounded-xl">
                        <span class="p-2">
                            <x-zondicon-stand-by class="w-4 h-4" />
                        </span>
                        Logout</button>
                </form>
            </li>
        </ul>
    </nav>
</div>
