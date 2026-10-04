

<?php $__env->startSection('title', 'আবেদন: ' . $application->tracking_no); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between mb-3">
    <h4>
        <i class="bi bi-file-earmark-text"></i>
        <?php echo e($application->certificateType->name_bn ?? ''); ?>

    </h4>
    <a href="<?php echo e(route('applicant.applications.index')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<?php
    $status = $application->status instanceof \Modules\Certificate\Enums\ApplicationStatus
        ? $application->status
        : \Modules\Certificate\Enums\ApplicationStatus::from($application->status ?? 'draft');
?>


<div class="alert alert-<?php echo e($status->color()); ?> d-flex justify-content-between align-items-center">
    <div>
        <strong>স্ট্যাটাস:</strong> <?php echo e($status->labelBn()); ?>

    </div>
    <code><?php echo e($application->tracking_no); ?></code>
</div>

<div class="row g-3">
    <div class="col-md-8">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>অগ্রগতি</strong></div>
            <div class="card-body">
                <?php
                    $steps = [
                        ['label' => 'আবেদন জমা', 'done' => true],
                        ['label' => 'পেমেন্ট', 'done' => $application->isPaid()],
                        ['label' => 'ওয়ার্ড সদস্য যাচাই', 'done' => in_array($status, [
                            \Modules\Certificate\Enums\ApplicationStatus::SENT_TO_CHAIRMAN,
                            \Modules\Certificate\Enums\ApplicationStatus::CHAIRMAN_APPROVED,
                            \Modules\Certificate\Enums\ApplicationStatus::READY_FOR_PRINT,
                            \Modules\Certificate\Enums\ApplicationStatus::PRINTED,
                            \Modules\Certificate\Enums\ApplicationStatus::DELIVERED,
                        ])],
                        ['label' => 'চেয়ারম্যান অনুমোদন', 'done' => in_array($status, [
                            \Modules\Certificate\Enums\ApplicationStatus::CHAIRMAN_APPROVED,
                            \Modules\Certificate\Enums\ApplicationStatus::READY_FOR_PRINT,
                            \Modules\Certificate\Enums\ApplicationStatus::PRINTED,
                            \Modules\Certificate\Enums\ApplicationStatus::DELIVERED,
                        ])],
                        ['label' => 'প্রিন্টের জন্য প্রস্তুত', 'done' => $application->canBePrinted()],
                    ];
                ?>

                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3
                        <?php echo e($step['done'] ? 'bg-success text-white' : 'bg-secondary text-white'); ?>"
                         style="width: 32px; height: 32px;">
                        <?php if($step['done']): ?>
                            <i class="bi bi-check"></i>
                        <?php else: ?>
                            <?php echo e(bangla_number($i + 1)); ?>

                        <?php endif; ?>
                    </div>
                    <div class="<?php echo e($step['done'] ? 'text-success fw-bold' : 'text-muted'); ?>">
                        <?php echo e($step['label']); ?>

                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>আবেদনের তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="35%">আবেদনকারী:</th><td><?php echo e($application->applicant_name_bn); ?></td></tr>
                    <tr><th>মোবাইল:</th><td><?php echo e($application->applicant_phone); ?></td></tr>
                    <tr><th>NID:</th><td><?php echo e($application->applicant_nid ?? '-'); ?></td></tr>
                    <tr><th>ওয়ার্ড:</th><td><?php echo e($application->ward->name_bn ?? '-'); ?></td></tr>
                    <tr><th>গ্রাম:</th><td><?php echo e($application->village->name_bn ?? '-'); ?></td></tr>
                    <tr><th>উদ্দেশ্য:</th><td><?php echo e($application->form_data['purpose'] ?? '-'); ?></td></tr>
                    <tr><th>ফি:</th><td><strong>৳ <?php echo e(bangla_number(number_format($application->amount, 0))); ?></strong></td></tr>
                    <tr><th>পেমেন্ট:</th>
                        <td>
                            <?php if($application->isPaid()): ?>
                                <span class="badge bg-success">পরিশোধিত</span>
                            <?php else: ?>
                                <span class="badge bg-danger">বাকি</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
       <?php if(!$application->isPaid()): ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-warning text-dark"><strong>পেমেন্ট প্রয়োজন</strong></div>
            <div class="card-body">
                <p class="small mb-2">আবেদন প্রক্রিয়া শুরু করতে ফি পরিশোধ করুন।</p>

                <a href="<?php echo e(route('applicant.payment.show', $application)); ?>"
                class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-credit-card"></i>
                    ৳ <?php echo e(bangla_number(number_format($application->amount, 0))); ?> পরিশোধ করুন
                </a>

                <?php if($application->payment_method === 'cash'): ?>
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-shop"></i>
                        অথবা অফিসে গিয়ে নগদ <?php echo e(bangla_number(number_format($application->amount, 0))); ?> টাকা পরিশোধ করুন।
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if($application->issuedCertificate): ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-success text-white"><strong><i class="bi bi-award"></i> সার্টিফিকেট</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>নম্বর:</th><td><code><?php echo e($application->issuedCertificate->certificate_no); ?></code></td></tr>
                    <tr><th>ইস্যু:</th><td><?php echo e(bangla_date($application->issuedCertificate->issue_date)); ?></td></tr>
                    <tr><th>মেয়াদ:</th><td><?php echo e(bangla_date($application->issuedCertificate->expiry_date)); ?></td></tr>
                </table>

               <div class="d-grid gap-2">
                    <?php if($application->canBePrinted()): ?>
                        <a href="<?php echo e(route('applicant.applications.print', $application)); ?>"
                        class="btn btn-success" target="_blank">
                            <i class="bi bi-printer"></i> প্রিন্ট করুন (PDF)
                        </a>
                    <?php else: ?>
                        <div class="alert alert-info small mb-0">
                            <i class="bi bi-lock"></i>
                            প্রিন্ট করা যাবে:
                            <strong><?php echo e(bangla_date($application->print_available_at)); ?></strong>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm"
                                data-bs-toggle="modal" data-bs-target="#earlyPrintModal">
                            <i class="bi bi-lightning"></i> তাড়াতাড়ি প্রিন্ট অনুরোধ
                        </button>
                    <?php endif; ?>

                    <a href="<?php echo e(route('verify.certificate', $application->issuedCertificate->verification_code)); ?>"
                    target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-qr-code"></i> অনলাইনে যাচাই করুন
                    </a>

                    
                    <?php if($application->issuedCertificate->expiry_date): ?>
                        <?php
                            $expired = $application->issuedCertificate->expiry_date->isPast();
                            $expiringSoon = !$expired && now()->diffInDays($application->issuedCertificate->expiry_date) <= 30;
                        ?>

                        <?php if(($expired || $expiringSoon) && $application->renewals()->whereIn('status', ['pending_payment','paid','sent_to_ward','sent_to_chairman','chairman_approved'])->count() === 0): ?>
                            <a href="<?php echo e(route('applicant.applications.renew', $application)); ?>"
                            class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-clockwise"></i>
                                <?php echo e($expired ? 'মেয়াদ শেষ - নবায়ন করুন' : 'শীঘ্রই শেষ - নবায়ন করুন'); ?>

                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                    <a href="<?php echo e(route('verify.certificate', $application->issuedCertificate->verification_code)); ?>"
                    target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-qr-code"></i> অনলাইনে যাচাই করুন
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($application->payment_status === 'paid'): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>রিসিট</strong></div>
            <div class="card-body">
                <a href="<?php echo e(route('applicant.applications.receipt', $application)); ?>"
                   class="btn btn-outline-primary w-100" target="_blank">
                    <i class="bi bi-file-earmark-text"></i> রিসিট ডাউনলোড
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="earlyPrintModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo e(route('applicant.applications.request-early-print', $application)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">তাড়াতাড়ি প্রিন্ট অনুরোধ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">কারণ <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ</button>
                    <button type="submit" class="btn btn-warning">অনুরোধ পাঠান</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('applicant::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/applications/show.blade.php ENDPATH**/ ?>