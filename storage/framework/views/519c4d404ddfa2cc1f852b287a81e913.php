<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold"><?php echo e(__('My Tours')); ?></h2>
                    <a href="<?php echo e(route('agent.tours.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add New Tour
                    </a>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <?php echo e(session('message')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Name</th>
                                <th class="py-2 px-4 border-b text-left">Destination</th>
                                <th class="py-2 px-4 border-b text-left">Duration</th>
                                <th class="py-2 px-4 border-b text-left">Price (Person/Couple)</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                                <th class="py-2 px-4 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4 border-b font-medium"><?php echo e($tour->name); ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <?php echo e($tour->main_destination); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tour->destinations ?? []) > 1): ?>
                                            <span class="text-xs text-gray-500">(+<?php echo e(count($tour->destinations) - 1); ?> more)</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="text-sm">
                                            <div>🛫 <?php echo e($tour->departure_date->format('d M Y')); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->arrival_date): ?>
                                                <div>🛬 <?php echo e($tour->arrival_date->format('d M Y')); ?></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="text-xs text-gray-500"><?php echo e($tour->duration_days); ?> Days</div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="text-sm">
                                            <div>👤 <?php echo e(number_format($tour->price_per_person)); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->price_per_couple): ?>
                                                <div class="text-xs text-gray-500">👥 <?php echo e(number_format($tour->price_per_couple)); ?></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <select wire:change="updateStatus(<?php echo e($tour->id); ?>, $event.target.value)" 
                                            class="text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-1 pl-2 pr-6
                                            <?php echo e($tour->status === 'booking_on' ? 'bg-green-50 text-green-800 border-green-200' : ($tour->status === 'booking_off' ? 'bg-yellow-50 text-yellow-800 border-yellow-200' : 'bg-gray-50 text-gray-800 border-gray-200')); ?>">
                                            <option value="booking_on" <?php echo e($tour->status === 'booking_on' ? 'selected' : ''); ?>>Booking ON</option>
                                            <option value="booking_off" <?php echo e($tour->status === 'booking_off' ? 'selected' : ''); ?>>Booking OFF</option>
                                            <option value="deactivated" <?php echo e($tour->status === 'deactivated' ? 'selected' : ''); ?>>Deactivate</option>
                                        </select>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="<?php echo e(route('agent.tours.edit', $tour->id)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <button wire:click="delete(<?php echo e($tour->id); ?>)" wire:confirm="Are you sure you want to delete this tour?" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">No tours found.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <?php echo e($tours->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\Chaloo\resources\views/livewire/agent/tour-list.blade.php ENDPATH**/ ?>