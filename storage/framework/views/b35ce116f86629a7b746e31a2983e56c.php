

<?php $__env->startSection('title', 'ড্যাশবোর্ড'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ইউনিয়ন</div>
                        <h3 class="mb-0"><?php echo e(bangla_number($stats['total_unions'])); ?></h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ওয়ার্ড</div>
                        <h3 class="mb-0"><?php echo e(bangla_number($stats['total_wards'])); ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-diagram-3 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট গ্রাম</div>
                        <h3 class="mb-0"><?php echo e(bangla_number($stats['total_villages'])); ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-house-door fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ইউজার</div>
                        <h3 class="mb-0"><?php echo e(bangla_number($stats['total_users'])); ?></h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($certificateStats)): ?>
<div class="row g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট আবেদন</div>
                <h3 class="mb-0 text-primary"><?php echo e(bangla_number($certificateStats['total_applications'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">অপেক্ষমাণ</div>
                <h3 class="mb-0 text-warning"><?php echo e(bangla_number($certificateStats['pending'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">অনুমোদিত</div>
                <h3 class="mb-0 text-success"><?php echo e(bangla_number($certificateStats['approved'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের আবেদন</div>
                <h3 class="mb-0 text-info"><?php echo e(bangla_number($certificateStats['today'])); ?></h3>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Core\resources/views/dashboard/index.blade.php ENDPATH**/ ?>