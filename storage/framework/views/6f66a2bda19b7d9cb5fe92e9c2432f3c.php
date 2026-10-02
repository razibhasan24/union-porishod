

<?php $__env->startSection('title', 'আমার আবেদন'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> আমার আবেদন</h4>
    <a href="<?php echo e(route('applicant.applications.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন আবেদন
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ট্র্যাকিং</th>
                        <th>ধরন</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                            ? $app->status
                            : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
                    ?>
                    <tr>
                        <td><?php echo e(bangla_number($loop->iteration + ($applications->currentPage() - 1) * $applications->perPage())); ?></td>
                        <td><code class="small"><?php echo e($app->tracking_no); ?></code></td>
                        <td><?php echo e($app->certificateType->name_bn ?? '-'); ?></td>
                        <td><span class="badge bg-<?php echo e($status->color()); ?>"><?php echo e($status->labelBn()); ?></span></td>
                        <td><?php echo e(bangla_date($app->created_at)); ?></td>
                        <td>
                            <a href="<?php echo e(route('applicant.applications.show', $app)); ?>"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> দেখুন
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            কোন আবেদন নেই।
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($applications->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('applicant::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/applications/index.blade.php ENDPATH**/ ?>