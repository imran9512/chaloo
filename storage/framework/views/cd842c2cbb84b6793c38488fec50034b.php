<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold"><?php echo e(__('Search Vehicles')); ?></h2>
                    <p class="text-sm text-gray-500">Showing transporter vehicles only</p>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                        <select wire:model.live="city" class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                            <option value="">All Cities</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c); ?>"><?php echo e($c); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vehicle
                            Type</label>
                        <select wire:model.live="selectedType"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                            <option value="">All Types</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                        <input type="date" wire:model.live="dateFrom"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-900">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="$set('city', '')"
                            class="text-sm text-gray-500 hover:text-gray-700 underline">Reset Filters</button>
                    </div>
                </div>

                <!-- Vehicle Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">

                            <!-- Image Slider -->
                            <div class="chaloo-slider relative">
                                <!-- Images Container with Fixed Aspect Ratio (3:2) -->
                                <div class="bg-gray-200 dark:bg-gray-700 overflow-hidden" style="aspect-ratio: 3/2;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($vehicle->images) && count($vehicle->images) > 0): ?>
                                        <div class="slider-track"
                                            style="display: flex; height: 100%; transition: transform 0.3s ease-out;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $vehicle->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="slider-slide" style="width: 100%; height: 100%; flex-shrink: 0;">
                                                    <img src="<?php echo e(asset('uploads/' . $image)); ?>" alt="<?php echo e($vehicle->name); ?>"
                                                        style="width: 100%; height: 100%; object-fit: cover; pointer-events: none;">
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                                            <span class="text-gray-500 dark:text-gray-400 text-2xl">🚗</span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Dots -->
                                <?php if(is_array($vehicle->images) && count($vehicle->images) > 1): ?>
                                    <div
                                        style="display: flex; justify-content: center; gap: 8px; padding: 12px 0; background-color: #f9fafb;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $vehicle->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button class="slider-dot" data-index="<?php echo e($index); ?>"
                                                style="width: 8px; height: 8px; border-radius: 50%; background-color: #d1d5db; border: none; cursor: pointer; transition: all 0.3s; padding: 0;"></button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Vehicle Details -->
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1">
                                        <?php echo e($vehicle->name); ?></h3>
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                        <?php echo e($vehicle->type->name ?? 'Vehicle'); ?>

                                    </span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate"><?php echo e($vehicle->city); ?></span>
                                </div>

                                <!-- Pricing -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Daily Rate</p>
                                            <p class="text-xl font-bold text-green-600">Rs.
                                                <?php echo e(number_format($vehicle->daily_rate)); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->driver_fee): ?>
                                                <p class="text-xs text-gray-500">+ Driver: Rs.
                                                    <?php echo e(number_format($vehicle->driver_fee)); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <a href="https://wa.me/<?php echo e(str_replace(['+', ' ', '-'], '', $vehicle->user->phone ?? '')); ?>?text=Hi, I am interested in your vehicle: <?php echo e($vehicle->name); ?>"
                                            target="_blank"
                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                            </svg>
                                            <span>Inquire</span>
                                        </a>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        Owner: <?php echo e($vehicle->user->name); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12 text-gray-500">
                            No vehicles found matching your criteria.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="mt-6">
                    <?php echo e($vehicles->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        initSliders();
    });

    document.addEventListener('livewire:navigated', function () {
        initSliders();
    });

    function initSliders() {
        const sliders = document.querySelectorAll('.chaloo-slider');

        sliders.forEach(slider => {
            const track = slider.querySelector('.slider-track');
            const dots = slider.querySelectorAll('.slider-dot');

            if (!track || dots.length === 0) return;

            let currentIndex = 0;
            let startX = 0;
            let currentTranslate = 0;
            let prevTranslate = 0;
            let isDragging = false;
            const totalSlides = dots.length;

            // Touch Events for Mobile Swipe
            track.addEventListener('touchstart', touchStart);
            track.addEventListener('touchend', touchEnd);
            track.addEventListener('touchmove', touchMove);

            function touchStart(event) {
                isDragging = true;
                startX = event.touches[0].clientX;
                track.style.transition = 'none';
            }

            function touchMove(event) {
                if (!isDragging) return;
                const currentX = event.touches[0].clientX;
                const diff = currentX - startX;

                // Add resistance at edges
                if ((currentIndex === 0 && diff > 0) || (currentIndex === totalSlides - 1 && diff < 0)) {
                    currentTranslate = prevTranslate + diff / 3;
                } else {
                    currentTranslate = prevTranslate + diff;
                }
                track.style.transform = `translateX(${currentTranslate}px)`;
            }

            function touchEnd() {
                isDragging = false;
                const movedBy = currentTranslate - prevTranslate;

                if (movedBy < -50 && currentIndex < totalSlides - 1) {
                    currentIndex += 1;
                } else if (movedBy > 50 && currentIndex > 0) {
                    currentIndex -= 1;
                }

                updateSlider();
            }

            // Dot click handlers
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function (e) {
                    e.stopPropagation();
                    currentIndex = index;
                    updateSlider();
                });
            });

            function updateSlider() {
                const containerWidth = slider.querySelector('[style*="aspect-ratio"]').clientWidth;
                const translatePercent = currentIndex * -100;

                track.style.transition = 'transform 0.3s ease-out';
                track.style.transform = `translateX(${translatePercent}%)`;

                prevTranslate = currentIndex * -containerWidth;

                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.style.backgroundColor = '#2563eb';
                        dot.style.transform = 'scale(1.2)';
                    } else {
                        dot.style.backgroundColor = '#d1d5db';
                        dot.style.transform = 'scale(1)';
                    }
                });
            }

            // Initialize
            const containerWidth = slider.querySelector('[style*="aspect-ratio"]').clientWidth;
            prevTranslate = currentIndex * -containerWidth;
            updateSlider();

            window.addEventListener('resize', () => {
                const containerWidth = slider.querySelector('[style*="aspect-ratio"]').clientWidth;
                prevTranslate = currentIndex * -containerWidth;
            });
        });
    }
</script><?php /**PATH D:\laragon\www\Chaloo\resources\views/livewire/agent/search-vehicles.blade.php ENDPATH**/ ?>