<nav x-data="{ mobileOpen: false }" @keydown.window.escape="mobileOpen = false"
    class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <button @click="mobileOpen = !mobileOpen" type="mobileOpen" aria-controls="mobile-menu"
                    aria-label="Main menu"
                    class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <a href="/" class="ml-3">
                    <span class="font-bold text-2xl text-indigo-600">Chaloo</span>
                </a>
            </div>

            <div class="flex items-center space-x-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="/dashboard" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Log
                        in</a>
                    <a href="<?php echo e(route('register')); ?>"
                        class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 rounded-lg shadow-md transition">Register</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Dim Background -->
    <div x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false" x-cloak
        class="fixed inset-0 bg-black/60 z-40 backdrop-blur-sm"></div>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" x-cloak id="mobile-menu"
        class="fixed inset-x-0 top-16 z-50 bg-white shadow-2xl border-t border-gray-200">

        <div class="px-6 py-8 space-y-3 max-h-[calc(100vh-4rem)] overflow-y-auto">
            <a href="<?php echo e(route('public.tours')); ?>" @click="mobileOpen = false"
                class="block px-5 py-4 text-lg font-semibold text-gray-800 hover:bg-indigo-50 rounded-2xl">Tours</a>

            <a href="<?php echo e(route('public.vehicles')); ?>" @click="mobileOpen = false"
                class="block px-5 py-4 text-lg font-semibold text-gray-800 hover:bg-indigo-50 rounded-2xl">Rent
                a Vehicle</a>

            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center px-5 py-4 text-lg font-semibold text-gray-800 hover:bg-indigo-50 rounded-2xl">
                    Pages
                    <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="ml-8 space-y-2 bg-gray-50 rounded-2xl p-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                            'pages.about' => 'About Us',
                            'pages.contact' => 'Contact Us',
                            'pages.privacy' => 'Privacy Policy',
                            'pages.terms' => 'Terms of Service',
                            'pages.disclaimer' => 'Disclaimer',
                            'pages.cookie' => 'Cookie Policy',
                            'pages.dmca' => 'DMCA Policy',
                            'pages.sitemap' => 'Sitemap',
                            'pages.author' => 'Author',
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route($route)); ?>" @click="mobileOpen = false"
                                   class="block px-5 py-3 text-gray-700 hover:bg-white hover:text-indigo-600 rounded-xl transition">
                                    <?php echo e($name); ?>

                                </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav><?php /**PATH D:\laragon\www\Chaloo\resources\views/components/public-header.blade.php ENDPATH**/ ?>