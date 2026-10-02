

<?php $__env->startSection('title', 'পেমেন্ট তালিকা'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-credit-card"></i> পেমেন্ট</h4>
    <a href="<?php echo e(route('payment.admin.cash-entry')); ?>" class="btn btn-primary">
        <i class="bi bi-cash-coin"></i> নগদ পেমেন্ট এন্ট্রি
    </a>
</div>


<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট আদায়</div>
                <h3 class="mb-0 text-success">৳ <?php echo e(bangla_number(number_format($stats['total_paid'], 0))); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের আদায়</div>
                <h3 class="mb-0 text-primary">৳ <?php echo e(bangla_number(number_format($stats['today_paid'], 0))); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের সংখ্যা</div>
                <h3 class="mb-0"><?php echo e(bangla_number($stats['today_count'])); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Pending Online</div>
                <h3 class="mb-0 text-warning"><?php echo e(bangla_number($stats['pending_online'])); ?></h3>
            </div>
        </div>
    </div>
</div>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       class="form-control" placeholder="ট্র্যাকিং/রিসিট/মোবাইল">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="success" <?php echo e(request('status') == 'success' ? 'selected' : ''); ?>>সফল</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>অপেক্ষমাণ</option>
                    <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>ব্যর্থ</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="method" class="form-select">
                    <option value="">সব পদ্ধতি</option>
                    <option value="online" <?php echo e(request('method') == 'online' ? 'selected' : ''); ?>>অনলাইন</option>
                    <option value="cash" <?php echo e(request('method') == 'cash' ? 'selected' : ''); ?>>নগদ</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="<?php echo e(route('payment.admin.index')); ?>" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>রিসিট/ট্র্যাকিং</th>
                        <th>আবেদনকারী</th>
                        <th>পরিমাণ</th>
                        <th>পদ্ধতি</th>
                        <th>স্ট্যাটাস</th>
                        <th>সময়</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(bangla_number($loop->iteration)); ?></td>
                        <td>
                            <code class="small"><?php echo e($p->receipt_no ?? $p->transaction_id); ?></code><br>
                            <small class="text-muted"><?php echo e($p->application->tracking_no ?? '-'); ?></small>
                        </td>
                        <td>
                            <?php echo e($p->application->applicant_name_bn ?? '-'); ?><br>
                            <small class="text-muted"><?php echo e($p->payer_mobile); ?></small>
                        </td>
                        <td><strong>৳ <?php echo e(bangla_number(number_format($p->amount, 0))); ?></strong></td>
                        <td>
                            <span class="badge bg-info"><?php echo e($p->method_label); ?></span>
                            <?php if($p->gateway): ?>
                                <br><small class="text-muted"><?php echo e($p->gateway_label); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge bg-<?php echo e($p->status_color); ?>"><?php echo e($p->status_label); ?></span></td>
                        <td><?php echo e($p->paid_at ? bangla_date($p->paid_at) : '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('payment.admin.show', $p)); ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if($p->status === 'success'): ?>
                            <a href="<?php echo e(route('payment.admin.receipt', $p)); ?>"
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">কোন পেমেন্ট নেই।</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($payments->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Payment\resources/views/admin/index.blade.php ENDPATH**/ ?>