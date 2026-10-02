

<?php $__env->startSection('title', 'সার্টিফিকেট ধরন'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> সার্টিফিকেট ধরন</h4>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('certificate_type.create')): ?>
    <a href="<?php echo e(route('certificate.types.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন ধরন
    </a>
    <?php endif; ?>
</div>


<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="union_id" class="form-select">
                    <option value="">সব ইউনিয়ন</option>
                    <?php $__currentLoopData = $unions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($u->id); ?>" <?php echo e(request('union_id') == $u->id ? 'selected' : ''); ?>>
                            <?php echo e($u->name_bn); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       class="form-control" placeholder="নাম বা কোড দিয়ে খুঁজুন...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="<?php echo e(route('certificate.types.index')); ?>" class="btn btn-secondary">Reset</a>
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
                        <th>নাম</th>
                        <th>কোড</th>
                        <th>ফি</th>
                        <th>বৈধতা</th>
                        <th>প্রিন্ট</th>
                        <th>স্ট্যাটাস</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(bangla_number($loop->iteration + ($types->currentPage() - 1) * $types->perPage())); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if($type->icon): ?>
                                    <span class="badge me-2" style="background: <?php echo e($type->color ?? '#3b82f6'); ?>;">
                                        <i class="bi bi-<?php echo e($type->icon); ?>"></i>
                                    </span>
                                <?php endif; ?>
                                <div>
                                    <strong><?php echo e($type->name_bn); ?></strong>
                                    <?php if($type->is_warish): ?>
                                        <span class="badge bg-purple ms-1" style="background:#8b5cf6;">ওয়ারিশ</span>
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-muted"><?php echo e($type->name_en); ?></small>
                                </div>
                            </div>
                        </td>
                        <td><code><?php echo e($type->code); ?></code></td>
                        <td><strong>৳ <?php echo e(bangla_number(number_format($type->fee, 0))); ?></strong></td>
                        <td><?php echo e(bangla_number($type->validity_days)); ?> দিন</td>
                        <td>
                            <?php if($type->print_after_days == 0): ?>
                                <span class="badge bg-success">সাথে সাথে</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">
                                    <?php echo e(bangla_number($type->print_after_days)); ?> দিন পর
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($type->is_active): ?>
                                <span class="badge bg-success">সক্রিয়</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('certificate.types.show', $type)); ?>"
                                   class="btn btn-info" title="দেখুন">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('certificate_type.edit')): ?>
                                <a href="<?php echo e(route('certificate.types.edit', $type)); ?>"
                                   class="btn btn-warning" title="সম্পাদনা">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('certificate_type.delete')): ?>
                                <form action="<?php echo e(route('certificate.types.destroy', $type)); ?>"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('নিশ্চিত ডিলিট করবেন?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger" title="ডিলিট">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            কোন সার্টিফিকেটের ধরন নেই।
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php echo e($types->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Certificate\resources/views/types/index.blade.php ENDPATH**/ ?>