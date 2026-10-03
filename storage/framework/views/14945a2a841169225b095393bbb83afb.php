

<?php $__env->startSection('title', 'নবায়ন'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-arrow-clockwise"></i> সার্টিফিকেট নবায়ন</h4>
    <a href="<?php echo e(route('applicant.dashboard')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>


<?php if($inProgressRenewals->count() > 0): ?>
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-warning text-dark">
        <strong><i class="bi bi-hourglass-split"></i> চলমান নবায়ন (<?php echo e(bangla_number($inProgressRenewals->count())); ?>)</strong>
    </div>
    <div class="card-body">
        <?php $__currentLoopData = $inProgressRenewals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                    ? $app->status
                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
            ?>
            <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo e($app->certificateType->name_bn ?? '-'); ?></strong>
                        <span class="badge bg-info ms-2">নবায়ন</span>
                        <br>
                        <small class="text-muted">
                            <code><?php echo e($app->tracking_no); ?></code> ·
                            মূল: <code><?php echo e($app->parentApplication->tracking_no ?? '-'); ?></code>
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?php echo e($status->color()); ?>"><?php echo e($status->labelBn()); ?></span>
                        <br>
                        <a href="<?php echo e(route('applicant.applications.show', $app)); ?>" class="btn btn-sm btn-link">
                            বিস্তারিত <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <strong><i class="bi bi-check-circle"></i> নবায়নযোগ্য সার্টিফিকেট (<?php echo e(bangla_number($renewableApplications->count())); ?>)</strong>
    </div>
    <div class="card-body">
        <?php $__empty_1 = true; $__currentLoopData = $renewableApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $certificate = $app->issuedCertificate;
                $isExpired = $certificate && $certificate->expiry_date && $certificate->expiry_date->isPast();
                $daysLeft = $certificate && $certificate->expiry_date && !$isExpired
                    ? now()->diffInDays($certificate->expiry_date)
                    : 0;
            ?>
            <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo e($app->certificateType->name_bn ?? '-'); ?></strong>
                        <?php if($isExpired): ?>
                            <span class="badge bg-danger ms-2">মেয়াদ শেষ</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark ms-2">
                                <?php echo e(bangla_number($daysLeft)); ?> দিন বাকি
                            </span>
                        <?php endif; ?>
                        <br>
                        <small class="text-muted">
                            <code><?php echo e($app->tracking_no); ?></code>
                            <?php if($certificate): ?>
                                · সার্টিফিকেট: <code><?php echo e($certificate->certificate_no); ?></code>
                                · মেয়াদ: <?php echo e(bangla_date($certificate->expiry_date)); ?>

                            <?php endif; ?>
                        </small>
                    </div>
                    <div class="text-end">
                        <div class="mb-2">
                            <small class="text-muted">নবায়ন ফি:</small>
                            <strong class="text-primary">
                                ৳ <?php echo e(bangla_number(number_format($app->certificateType->renewal_fee ?? $app->certificateType->fee ?? 0, 0))); ?>

                            </strong>
                        </div>
                        <a href="<?php echo e(route('applicant.applications.renew', $app)); ?>"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> নবায়ন করুন
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                কোন নবায়নযোগ্য সার্টিফিকেট নেই।
                <br>
                <small>সার্টিফিকেটের মেয়াদ শেষ হওয়ার ৩০ দিন আগে বা পরে নবায়ন করা যাবে।</small>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('applicant::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/renewals/index.blade.php ENDPATH**/ ?>