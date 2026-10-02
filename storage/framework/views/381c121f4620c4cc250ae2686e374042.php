

<?php $__env->startSection('title', 'নগদ পেমেন্ট এন্ট্রি'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-cash-coin"></i> নগদ পেমেন্ট এন্ট্রি</h4>
    <a href="<?php echo e(route('payment.admin.index')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>আবেদনকারীর কাছ থেকে নগদ পেমেন্ট গ্রহণ</strong></div>
            <div class="card-body">
                <form action="<?php echo e(route('payment.admin.cash-store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">ট্র্যাকিং নম্বর <span class="text-danger">*</span></label>
                        <input type="text" name="tracking_no" value="<?php echo e(old('tracking_no')); ?>"
                               class="form-control <?php $__errorArgs = ['tracking_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="CERT-20251002-ABC123" required>
                        <?php $__errorArgs = ['tracking_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">আবেদনকারীর কাছ থেকে ট্র্যাকিং নম্বর নিন</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">পরিমাণ (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="amount" value="<?php echo e(old('amount')); ?>"
                               class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               step="0.01" required>
                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">রিসিট নম্বর (ঐচ্ছিক)</label>
                        <input type="text" name="receipt_no" value="<?php echo e(old('receipt_no')); ?>"
                               class="form-control" placeholder="খালি রাখলে অটো তৈরি হবে">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">নোট</label>
                        <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> পেমেন্ট রেকর্ড করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Payment\resources/views/admin/cash-entry.blade.php ENDPATH**/ ?>