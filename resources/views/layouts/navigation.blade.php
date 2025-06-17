<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white transition-all duration-300 transform"
        x-data="{ submenuOpen: false }" :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 bg-gray-900 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span
                    class="text-xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">SIA</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen"
                class="text-gray-400 hover:text-white focus:outline-none transition-colors duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- User Info -->
        <div class="px-4 py-3 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                    <span class="text-lg font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-5 px-2 space-y-1">
            @if (Auth::user()->role === 'admin')
                <!-- Menu Admin -->
                <div class="space-y-2">
                    <!-- dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.accounts.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.accounts.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.accounts.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Akun
                    </a>

                    <a href="{{ route('admin.transactions.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.transactions.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Transaksi
                    </a>
                    {{-- <a href="{{ route('admin.adjustments.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.adjustment.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.adjustment.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 1.343-3 3v4m0 0h6m-6 0H9a2 2 0 01-2-2v-4a4 4 0 014-4h1a4 4 0 014 4v4a2 2 0 01-2 2h-1z" />
                        </svg>
                        Jurnal Penyesuaian
                    </a> --}}

                    {{-- <a href="{{ route('admin.closings.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.closings.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.closings.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Jurnal Penutup
                    </a> --}}
                    <a href="{{ route('admin.ledger.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.ledger.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.ledger.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h10M4 18h6" />
                        </svg>
                        Buku Besar
                    </a>


                    <div class="space-y-1">
                        <button type="button" @click="submenuOpen = !submenuOpen"
                            class="group w-full flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition-all duration-200">
                            <svg class="mr-4 h-6 w-6 transition-colors duration-200 text-gray-400 group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Laporan
                            <svg class="ml-auto h-5 w-5 transform transition-transform duration-200"
                                :class="{ 'rotate-90': submenuOpen }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="submenuOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" class="space-y-1">
                            <a href="{{ route('admin.reports.income-statement') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Laba Rugi
                            </a>
                            <a href="{{ route('admin.reports.balance-sheet') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Neraca
                            </a>
                            <a href="{{ route('admin.reports.cash-flow') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Arus Kas
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Menu Staff -->

                <div class="space-y-2">
                    <a href="{{ route('staff.dashboard') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('staff.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('staff.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('staff.transactions.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('staff.transactions.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('staff.transactions.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Transaksi
                    </a>
                    {{-- <a href="{{ route('staff.transactions.adjustment') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('staff.transactions.adjustment') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('staff.transactions.adjustment') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 1.343-3 3v4m0 0h6m-6 0H9a2 2 0 01-2-2v-4a4 4 0 014-4h1a4 4 0 014 4v4a2 2 0 01-2 2h-1z" />
                        </svg>
                        Jurnal Penyesuaian
                    </a> --}}

                    {{-- <a href="{{ route('staff.transactions.closing') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('staff.transactions.closing') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('staff.transactions.closing') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Jurnal Penutup
                    </a> --}}


                    <a href="{{ route('staff.ledger.index') }}"
                        class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md transition-all duration-200 {{ request()->routeIs('admin.ledger.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <svg class="mr-4 h-6 w-6 transition-colors duration-200 {{ request()->routeIs('admin.ledger.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h10M4 18h6" />
                        </svg>
                        Buku Besar
                    </a>




                    <div class="space-y-1">
                        <button type="button" @click="submenuOpen = !submenuOpen"
                            class="group w-full flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition-all duration-200">
                            <svg class="mr-4 h-6 w-6 transition-colors duration-200 text-gray-400 group-hover:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Laporan
                            <svg class="ml-auto h-5 w-5 transform transition-transform duration-200"
                                :class="{ 'rotate-90': submenuOpen }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div x-show="submenuOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" class="space-y-1">
                            <a href="{{ route('staff.reports.income-statement') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Laba Rugi
                            </a>
                            <a href="{{ route('staff.reports.balance-sheet') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Neraca
                            </a>
                            <a href="{{ route('staff.reports.cash-flow') }}"
                                class="group flex items-center pl-11 pr-2 py-2 text-sm leading-5 font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none focus:bg-gray-700 transition-all duration-200">
                                Arus Kas
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Logout Button -->
        <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
            <button type="button" onclick="document.getElementById('logoutModal').classList.remove('hidden')"
                class="w-full flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:bg-red-600 hover:text-white transition-all duration-200">
                <svg class="mr-4 h-6 w-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </div>

    </aside>

    <!-- Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen"
        class="fixed top-4 left-4 z-50 p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 transition-all duration-200"
        x-show="!sidebarOpen">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div id="logoutModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-gray-800 text-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-xl font-semibold mb-4">Konfirmasi Logout</h2>
            <p class="mb-6 text-gray-300">Apakah kamu yakin ingin logout dari aplikasi?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')"
                    class="px-4 py-2 rounded-md text-gray-300 hover:bg-gray-700 transition">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
