

<?php $__env->startSection('title', 'নতুন আবেদন'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-plus-circle"></i> নতুন আবেদন</h4>
    <a href="<?php echo e(route('applicant.applications.index')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="<?php echo e(route('applicant.applications.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="row g-3">
        <div class="col-md-8">
            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>সার্টিফিকেটের ধরন</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <label class="cert-type-card border rounded p-3 d-block text-center"
                                   style="cursor: pointer; height: 100%;">
                                <input type="radio" name="certificate_type_id" value="<?php echo e($type->id); ?>"
                                       class="d-none" required
                                       data-fee="<?php echo e($type->fee); ?>"
                                       data-warish="<?php echo e($type->is_warish ? 1 : 0); ?>"
                                       <?php echo e(old('certificate_type_id') == $type->id ? 'checked' : ''); ?>>
                                <i class="bi bi-<?php echo e($type->icon ?? 'file-text'); ?> fs-2"
                                   style="color: <?php echo e($type->color ?? '#3b82f6'); ?>;"></i>
                                <div class="mt-2 fw-bold"><?php echo e($type->name_bn); ?></div>
                                <div class="text-muted small">৳ <?php echo e(bangla_number(number_format($type->fee, 0))); ?></div>
                            </label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['certificate_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>ব্যক্তিগত তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">পিতার নাম</label>
                            <input type="text" name="father_name" value="<?php echo e(old('father_name')); ?>"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মাতার নাম</label>
                            <input type="text" name="mother_name" value="<?php echo e(old('mother_name')); ?>"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ওয়ার্ড <span class="text-danger">*</span></label>
                            <select name="ward_id" class="form-select" required>
                                <option value="">-- নির্বাচন --</option>
                                <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($w->id); ?>"
                                        <?php echo e(old('ward_id', auth()->user()->ward_id) == $w->id ? 'selected' : ''); ?>>
                                        <?php echo e($w->name_bn); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">গ্রাম</label>
                            <select name="village_id" class="form-select">
                                <option value="">-- নির্বাচন --</option>
                                <?php $__currentLoopData = $villages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($v->id); ?>"
                                        <?php echo e(old('village_id', auth()->user()->village_id) == $v->id ? 'selected' : ''); ?>>
                                        <?php echo e($v->name_bn); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">ঠিকানা</label>
                            <input type="text" name="address" value="<?php echo e(old('address')); ?>"
                                   class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">উদ্দেশ্য <span class="text-danger">*</span></label>
                            <textarea name="purpose" rows="3" class="form-control" required
                                      placeholder="কেন এই সার্টিফিকেট দরকার..."><?php echo e(old('purpose')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>ডকুমেন্ট সংযুক্তি</strong></div>
                <div class="card-body">
                    <input type="file" name="documents[]" class="form-control mb-2" multiple
                           accept="image/*,application/pdf">
                    <small class="text-muted">
                        NID কপি, ছবি ইত্যাদি (সর্বোচ্চ ৫MB প্রতিটি)
                    </small>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 d-none" id="warishSection">
                <div class="card-header bg-warning text-dark">
                    <strong>ওয়ারিশ তথ্য</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">মৃত ব্যক্তির নাম</label>
                            <input type="text" name="deceased_info[name]" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মৃত্যুর তারিখ</label>
                            <input type="date" name="deceased_info[death_date]" class="form-control">
                        </div>
                    </div>

                    <label class="form-label"><strong>উত্তরাধিকারীবৃন্দ:</strong></label>
                    <div id="heirsContainer">
                        <div class="row g-2 mb-2 heir-row">
                            <div class="col-md-4">
                                <input type="text" name="heirs[0][name]" class="form-control" placeholder="নাম">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="heirs[0][relation]" class="form-control" placeholder="সম্পর্ক">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="heirs[0][age]" class="form-control" placeholder="বয়স">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="heirs[0][nid]" class="form-control" placeholder="NID">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addHeirBtn">
                        <i class="bi bi-plus-circle"></i> আরও যোগ করুন
                    </button>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>পেমেন্ট পদ্ধতি</strong></div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input type="radio" name="payment_method" value="online" id="pay_online"
                               class="form-check-input" required checked>
                        <label class="form-check-label" for="pay_online">
                            <i class="bi bi-credit-card"></i> অনলাইন (bKash/Nagad)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input type="radio" name="payment_method" value="cash" id="pay_cash"
                               class="form-check-input">
                        <label class="form-check-label" for="pay_cash">
                            <i class="bi bi-cash"></i> অফিসে নগদ
                        </label>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>ফি:</span>
                        <strong id="feeDisplay">৳ ০</strong>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> আবেদন জমা দিন
                </button>
                <a href="<?php echo e(route('applicant.applications.index')); ?>" class="btn btn-secondary">বাতিল</a>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .cert-type-card { transition: all 0.2s; }
    .cert-type-card:hover { border-color: #0d6efd !important; background: #f8f9fa; }
    .cert-type-card.selected { border-color: #0d6efd !important; background: #e7f1ff; border-width: 2px !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.cert-type-card');
    const feeDisplay = document.getElementById('feeDisplay');
    const warishSection = document.getElementById('warishSection');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            const fee = radio.dataset.fee || 0;
            feeDisplay.textContent = '৳ ' + Number(fee).toLocaleString('bn-BD');

            if (radio.dataset.warish === '1') {
                warishSection.classList.remove('d-none');
            } else {
                warishSection.classList.add('d-none');
            }
        });
    });

    // Add heir button
    let heirIndex = 1;
    document.getElementById('addHeirBtn')?.addEventListener('click', function() {
        const container = document.getElementById('heirsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2 heir-row';
        newRow.innerHTML = `
            <div class="col-md-4"><input type="text" name="heirs[${heirIndex}][name]" class="form-control" placeholder="নাম"></div>
            <div class="col-md-3"><input type="text" name="heirs[${heirIndex}][relation]" class="form-control" placeholder="সম্পর্ক"></div>
            <div class="col-md-2"><input type="number" name="heirs[${heirIndex}][age]" class="form-control" placeholder="বয়স"></div>
            <div class="col-md-3"><input type="text" name="heirs[${heirIndex}][nid]" class="form-control" placeholder="NID"></div>
        `;
        container.appendChild(newRow);
        heirIndex++;
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('applicant::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/applications/create.blade.php ENDPATH**/ ?>