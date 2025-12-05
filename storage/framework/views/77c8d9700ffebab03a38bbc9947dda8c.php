

<?php $__env->startSection('content'); ?>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">

        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Chaloo</h1>
            <p class="text-xl text-gray-600">Your ultimate travel companion. Explore tours or rent a
                vehicle today.</p>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <!-- Tours Card -->
            <a href="<?php echo e(route('public.tours')); ?>"
                class="group relative block p-8 bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                </div>
                <div class="flex flex-col items-center text-center">
                    <div
                        class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-4xl">🏖️</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Browse Tours</h2>
                    <p class="text-gray-600">Discover amazing destinations and curated tour packages for
                        your next adventure.</p>
                    <div class="mt-6 text-blue-600 font-semibold flex items-center">
                        Explore Tours <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </div>
            </a>

            <!-- Vehicles Card -->
            <a href="<?php echo e(route('public.vehicles')); ?>"
                class="group relative block p-8 bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                </div>
                <div class="flex flex-col items-center text-center">
                    <div
                        class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-4xl">🚗</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Rent a Vehicle</h2>
                    <p class="text-gray-600">Find the perfect ride for your journey. Choose from our wide
                        range of reliable vehicles.</p>
                    <div class="mt-6 text-green-600 font-semibold flex items-center">
                        Find a Ride <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </div>
            </a>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Chaloo\resources\views/welcome.blade.php ENDPATH**/ ?>