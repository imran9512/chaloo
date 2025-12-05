<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-2xl font-bold mb-6"><?php echo e(__('Pending Approvals')); ?></h2>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <?php echo e(session('message')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(session()->has('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4 border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Details -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">User Information</h3>
                                <div class="space-y-2">
                                    <div>
                                        <span class="font-semibold">Name:</span>
                                        <span class="ml-2"><?php echo e($user->name); ?></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Email:</span>
                                        <span class="ml-2"><?php echo e($user->email); ?></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Phone:</span>
                                        <span class="ml-2"><?php echo e($user->phone); ?></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">City:</span>
                                        <span class="ml-2"><?php echo e($user->city); ?></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Role:</span>
                                        <span class="ml-2 capitalize"><?php echo e($user->role); ?></span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->company_name): ?>
                                        <div>
                                            <span class="font-semibold">Company:</span>
                                            <span class="ml-2"><?php echo e($user->company_name); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div>
                                        <span class="font-semibold">Registered:</span>
                                        <span class="ml-2"><?php echo e($user->created_at->format('d M Y, h:i A')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">Uploaded Documents</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- ID Card -->
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">ID Card (Front)</p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->id_card_image): ?>
                                            <?php if (isset($component)) { $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lightbox-image','data' => ['src' => route('storage.serve', ['path' => $user->id_card_image], false),'alt' => 'ID Card Front']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lightbox-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('storage.serve', ['path' => $user->id_card_image], false)),'alt' => 'ID Card Front']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $attributes = $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $component = $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-red-500 text-xs">Missing</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">ID Card (Back)</p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->id_card_back_image): ?>
                                            <?php if (isset($component)) { $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lightbox-image','data' => ['src' => route('storage.serve', ['path' => $user->id_card_back_image], false),'alt' => 'ID Card Back']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lightbox-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('storage.serve', ['path' => $user->id_card_back_image], false)),'alt' => 'ID Card Back']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $attributes = $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $component = $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-red-500 text-xs">Missing</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <!-- License -->
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">License (Front)</p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->license_image): ?>
                                            <?php if (isset($component)) { $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lightbox-image','data' => ['src' => route('storage.serve', ['path' => $user->license_image], false),'alt' => 'License Front']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lightbox-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('storage.serve', ['path' => $user->license_image], false)),'alt' => 'License Front']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $attributes = $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $component = $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-red-500 text-xs">Missing</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold mb-2 text-sm">License (Back)</p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->license_back_image): ?>
                                            <?php if (isset($component)) { $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.lightbox-image','data' => ['src' => route('storage.serve', ['path' => $user->license_back_image], false),'alt' => 'License Back']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lightbox-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('storage.serve', ['path' => $user->license_back_image], false)),'alt' => 'License Back']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $attributes = $__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__attributesOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5)): ?>
<?php $component = $__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5; ?>
<?php unset($__componentOriginal842d0be20a8c99de9cf9da735d8ff5a5); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-red-500 text-xs">Missing</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex gap-3 justify-end">
                            <button wire:click="approve(<?php echo e($user->id); ?>)"
                                wire:confirm="Are you sure you want to approve <?php echo e($user->name); ?>?"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                                ✓ Approve
                            </button>
                            <button wire:click="reject(<?php echo e($user->id); ?>)"
                                wire:confirm="Are you sure you want to reject <?php echo e($user->name); ?>?"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                ✗ Reject
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No pending approvals</h3>
                        <p class="mt-1 text-sm text-gray-500">All registrations have been processed.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pendingUsers->hasPages()): ?>
                    <div class="mt-6">
                        <?php echo e($pendingUsers->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\Chaloo\resources\views/livewire/admin/pending-approvals.blade.php ENDPATH**/ ?>