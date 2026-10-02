

<?php $__env->startSection('title', 'ড্যাশবোর্ড'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট আবেদন</div>
                        <h3 class="mb-0 text-primary"><?php echo e(bangla_number($stats['total'])); ?></h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">অপেক্ষমাণ</div>
                        <h3 class="mb-0 text-warning"><?php echo e(bangla_number($stats['pending'])); ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">অনুমোদিত</div>
                        <h3 class="mb-0 text-success"><?php echo e(bangla_number($stats['approved'])); ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">বাতিল</div>
                        <h3 class="mb-0 text-danger"><?php echo e(bangla_number($stats['rejected'])); ?></h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong><i class="bi bi-clock-history"></i> সাম্প্রতিক আবেদন</strong>
        <a href="<?php echo e(route('applicant.applications.create')); ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> নতুন আবেদন
        </a>
    </div>
    <div class="card-body">
        <?php $__empty_1 = true; $__currentLoopData = $recentApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                    ? $app->status
                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
            ?>
            <div class="border rounded p-3 mb-2 hover-bg">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo e($app->certificateType->name_bn ?? '-'); ?></strong>
                        <br>
                        <small class="text-muted">
                            <code><?php echo e($app->tracking_no); ?></code> ·
                            <?php echo e(bangla_date($app->created_at)); ?>

                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?php echo e($status->color()); ?>"><?php echo e($status->labelBn()); ?></span>
                        <br>
                        <a href="<?php echo e(route('applicant.applications.show', $app)); ?>"
                           class="btn btn-sm btn-link">বিস্তারিত <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                কোন আবেদন নেই। নতুন আবেদন করতে উপরের বাটনে ক্লিক করুন।
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('applicant::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/dashboard/index.blade.php ENDPATH**/ ?>