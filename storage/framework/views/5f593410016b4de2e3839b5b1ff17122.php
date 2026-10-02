

<?php $__env->startSection('title', 'সার্টিফিকেট আবেদন'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-check"></i> সার্টিফিকেট আবেদন</h4>
</div>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       class="form-control" placeholder="ট্র্যাকিং/নাম/ফোন/NID">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>খসড়া</option>
                    <option value="sent_to_ward" <?php echo e(request('status') == 'sent_to_ward' ? 'selected' : ''); ?>>ওয়ার্ডে পাঠানো</option>
                    <option value="sent_to_chairman" <?php echo e(request('status') == 'sent_to_chairman' ? 'selected' : ''); ?>>চেয়ারম্যানে পাঠানো</option>
                    <option value="chairman_approved" <?php echo e(request('status') == 'chairman_approved' ? 'selected' : ''); ?>>অনুমোদিত</option>
                    <option value="ward_rejected" <?php echo e(request('status') == 'ward_rejected' ? 'selected' : ''); ?>>ওয়ার্ড বাতিল</option>
                    <option value="chairman_rejected" <?php echo e(request('status') == 'chairman_rejected' ? 'selected' : ''); ?>>চেয়ারম্যান বাতিল</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="ward_id" class="form-select">
                    <option value="">সব ওয়ার্ড</option>
                    <?php $__currentLoopData = \Modules\Core\Models\Ward::orderBy('ward_no')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w->id); ?>" <?php echo e(request('ward_id') == $w->id ? 'selected' : ''); ?>>
                            <?php echo e($w->name_bn); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="<?php echo e(route('certificate.applications.index')); ?>" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ট্র্যাকিং</th>
                        <th>আবেদনকারী</th>
                        <th>ধরন</th>
                        <th>ওয়ার্ড</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(bangla_number($loop->iteration + ($applications->currentPage() - 1) * $applications->perPage())); ?></td>
                        <td><code class="small"><?php echo e($app->tracking_no); ?></code></td>
                        <td>
                            <strong><?php echo e($app->applicant_name_bn); ?></strong><br>
                            <small class="text-muted"><?php echo e($app->applicant_phone); ?></small>
                        </td>
                        <td><?php echo e($app->certificateType->name_bn ?? '-'); ?></td>
                        <td><?php echo e($app->ward->name_bn ?? '-'); ?></td>
                        <td>
                            <?php
                                $statusVal = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                                    ? $app->status
                                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
                            ?>
                            <span class="badge bg-<?php echo e($statusVal->color()); ?>">
                                <?php echo e($statusVal->labelBn()); ?>

                            </span>
                        </td>
                        <td><?php echo e(bangla_date($app->created_at)); ?></td>
                        <td>
                            <a href="<?php echo e(route('certificate.applications.show', $app)); ?>"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
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
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Certificate\resources/views/applications/index.blade.php ENDPATH**/ ?>