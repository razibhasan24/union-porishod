

<?php $__env->startSection('title', 'SMS লগ'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-chat-dots"></i> SMS লগ</h4>
    <a href="<?php echo e(route('setting.sms-send.form')); ?>" class="btn btn-primary">
        <i class="bi bi-send"></i> নতুন SMS পাঠান
    </a>
</div>


<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট</div>
                <h3 class="mb-0"><?php echo e(bangla_number($stats['total'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">পাঠানো</div>
                <h3 class="mb-0 text-success"><?php echo e(bangla_number($stats['sent'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">ব্যর্থ</div>
                <h3 class="mb-0 text-danger"><?php echo e(bangla_number($stats['failed'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজ</div>
                <h3 class="mb-0 text-primary"><?php echo e(bangla_number($stats['today'])); ?></h3>
            </div>
        </div>
    </div>
</div>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="মোবাইল / মেসেজ / টেমপ্লেট">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="sent" <?php echo e(request('status') == 'sent' ? 'selected' : ''); ?>>পাঠানো</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>অপেক্ষমাণ</option>
                    <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>ব্যর্থ</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="<?php echo e(route('setting.sms-logs.index')); ?>" class="btn btn-secondary">Reset</a>
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
                        <th>মোবাইল</th>
                        <th>মেসেজ</th>
                        <th>টেমপ্লেট</th>
                        <th>গেটওয়ে</th>
                        <th>স্ট্যাটাস</th>
                        <th>সময়</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(bangla_number($loop->iteration + ($logs->currentPage() - 1) * $logs->perPage())); ?></td>
                        <td><?php echo e($log->mobile); ?></td>
                        <td>
                            <small><?php echo e(\Illuminate\Support\Str::limit($log->message, 60)); ?></small>
                        </td>
                        <td><span class="badge bg-secondary"><?php echo e($log->template_key ?? '-'); ?></span></td>
                        <td><span class="badge bg-info"><?php echo e($log->gateway ?? '-'); ?></span></td>
                        <td>
                            <span class="badge bg-<?php echo e($log->status_color); ?>"><?php echo e($log->status_label); ?></span>
                        </td>
                        <td>
                            <small><?php echo e(bangla_date($log->created_at)); ?></small>
                        </td>
                        <td>
                            <a href="<?php echo e(route('setting.sms-logs.show', $log)); ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">কোন লগ নেই</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($logs->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Setting\resources/views/sms/logs.blade.php ENDPATH**/ ?>