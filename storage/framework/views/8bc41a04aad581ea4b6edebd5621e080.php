

<?php $__env->startSection('title', 'SMS টেমপ্লেট'); ?>

<?php $__env->startSection('content'); ?>
<h4 class="mb-3"><i class="bi bi-file-earmark-text"></i> SMS টেমপ্লেট</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Key</th>
                    <th>নাম</th>
                    <th>স্ট্যাটাস</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(bangla_number($loop->iteration)); ?></td>
                    <td><code><?php echo e($t->key); ?></code></td>
                    <td><?php echo e($t->name_bn); ?></td>
                    <td>
                        <?php if($t->is_active): ?>
                            <span class="badge bg-success">সক্রিয়</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('setting.sms-templates.edit', $t)); ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> সম্পাদনা
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($templates->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Setting\resources/views/sms/templates.blade.php ENDPATH**/ ?>