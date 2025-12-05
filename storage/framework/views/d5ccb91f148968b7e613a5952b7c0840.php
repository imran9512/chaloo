<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Agent Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Package Status Widget -->
            <?php
                $activePackage = \App\Models\UserPackage::where('user_id', auth()->id())
                    ->where('status', 'active')
                    ->first();
                $tourCount = auth()->user()->tours()->count();
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePackage && $activePackage->isActive()): ?>
                <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        <h3 class="text-lg font-semibold mb-3">📦 Your Package:
                            <?php echo e($activePackage->package->name ?? 'Custom Package'); ?></h3>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <div class="text-green-100">Tour Listings</div>
                                <div class="text-2xl font-bold"><?php echo e($tourCount); ?> / <?php echo e($activePackage->listing_limit); ?></div>
                            </div>
                            <div>
                                <div class="text-green-100">Days Left</div>
                                <div class="text-2xl font-bold">
                                    <?php echo e(max(0, now()->diffInDays($activePackage->expires_at, false))); ?></div>
                            </div>
                            <div>
                                <div class="text-green-100">Expires On</div>
                                <div class="lg:text-lg font-semibold"><?php echo e($activePackage->expires_at->format('d M Y')); ?>

                                </div>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tourCount >= $activePackage->listing_limit): ?>
                            <div class="mt-3 bg-yellow-500 text-yellow-900 px-3 py-2 rounded text-sm">
                                ⚠️ Listing limit reached! Upgrade to add more tours.
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="mt-4">
                            <a href="<?php echo e(route('agent.buy-packages')); ?>"
                                class="inline-block bg-white text-green-600 hover:bg-green-50 font-bold py-2 px-4 rounded border border-white">
                                🔄 Upgrade Package
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4">
                    <p class="text-yellow-800 font-semibold mb-3">⚠️ No active package. Purchase a package to start listing
                        tours.</p>
                    <a href="<?php echo e(route('agent.buy-packages')); ?>"
                        class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        📦 Buy Packages
                    </a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4"><?php echo e(__("Welcome back, Agent!")); ?></h3>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->status !== 'active'): ?>
                        <!-- Red Warning for Unapproved Users -->
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">⚠️ Account Not Approved</p>
                            <p>Your account is not yet approved. Please complete the activation process below to get
                                approved by our admin team. Until approval, your tour listings will not be visible to
                                guests.</p>
                        </div>

                        <?php if(auth()->user()->status === 'pending_approval'): ?>
                            <div class="mt-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                                <p class="font-bold">Account Pending Approval</p>
                                <p>Your documents have been submitted and are under review. You will be notified once your
                                    account is active.</p>
                            </div>
                        <?php else: ?>
                            <div class="mt-6">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('shared.activation-form');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1055426660-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <div class="mt-4">
                            <a href="<?php echo e(route('agent.tours')); ?>" class="text-blue-500 hover:underline font-semibold">Manage
                                Tours</a> |
                            <a href="<?php echo e(route('agent.search-vehicles')); ?>" class="text-blue-500 hover:underline">Search
                                Vehicles</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\Chaloo\resources\views/agent/dashboard.blade.php ENDPATH**/ ?>