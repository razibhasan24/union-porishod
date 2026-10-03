<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?> — হোম</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'SolaimanLipi', 'Segoe UI', sans-serif;
            background: #f8f9fa;
        }

        .hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4d8c 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .card-action {
            transition: all 0.3s;
            border: none;
            border-radius: 12px;
            height: 100%;
        }

        .card-action:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-action .icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo e(route('home')); ?>">
                <?php if(current_union()?->logo): ?>
                    <img src="<?php echo e(asset('storage/' . current_union()->logo)); ?>" width="35" height="35"
                        class="me-2 rounded bg-white p-1" alt="Logo">
                <?php endif; ?>
                <?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?>

            </a>
            <div class="ms-auto">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isApplicant()): ?>
                        <a href="<?php echo e(route('applicant.dashboard')); ?>" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('core.dashboard')); ?>" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-speedometer2"></i> অ্যাডমিন প্যানেল
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> লগইন
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-person-plus"></i> নিবন্ধন
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    
    <section class="hero">
        <div class="container">
            <h1><?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?></h1>
            <p><?php echo e(current_union()?->upazila_bn ?? ''); ?><?php if(current_union()?->district_bn): ?>
                    , <?php echo e(current_union()->district_bn); ?>

                <?php endif; ?>
            </p>
            <p class="mt-4">অনলাইনে আবেদন করুন, যাচাই করুন এবং সেবা গ্রহণ করুন</p>

            <?php if(auth()->guard()->guest()): ?>
                <div class="mt-4">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-warning btn-lg me-2">
                        <i class="bi bi-file-earmark-plus"></i> নতুন আবেদন
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> লগইন করুন
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="<?php echo e(route('verify.form')); ?>" class="text-decoration-none">
                    <div class="card card-action shadow-sm text-center p-4">
                        <div class="icon text-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="text-dark">সার্টিফিকেট যাচাই</h4>
                        <p class="text-muted">QR কোড বা কোড দিয়ে যেকোনো সার্টিফিকেটের সত্যতা যাচাই করুন</p>
                        <span class="btn btn-success btn-sm">
                            <i class="bi bi-search"></i> যাচাই করুন
                        </span>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?php echo e(route('register')); ?>" class="text-decoration-none">
                    <div class="card card-action shadow-sm text-center p-4">
                        <div class="icon text-primary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4 class="text-dark">অনলাইন আবেদন</h4>
                        <p class="text-muted">নাগরিকত্ব, চারিত্রিক, আয়, ওয়ারিশ সহ সব ধরনের সার্টিফিকেটের জন্য আবেদন
                            করুন</p>
                        <span class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> আবেদন করুন
                        </span>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?php echo e(route('login')); ?>" class="text-decoration-none">
                    <div class="card card-action shadow-sm text-center p-4">
                        <div class="icon text-warning">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="text-dark">আমার অ্যাকাউন্ট</h4>
                        <p class="text-muted">আবেদনের অবস্থা, রিসিট, সার্টিফিকেট সব এক জায়গায় দেখুন</p>
                        <span class="btn btn-warning btn-sm">
                            <i class="bi bi-box-arrow-in-right"></i> লগইন
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    
    <section class="bg-white py-5">
        <div class="container">
            <h3 class="text-center mb-4">আমাদের সেবাসমূহ</h3>
            <div class="row g-3 text-center">
                <div class="col-md-3 col-6">
                    <i class="bi bi-file-earmark-text text-primary fs-1"></i>
                    <h6 class="mt-2">সার্টিফিকেট</p>
                        <small class="text-muted">১২+ ধরনের সনদ</small>
                </div>
                <div class="col-md-3 col-6">
                    <i class="bi bi-people text-success fs-1"></i>
                    <h6 class="mt-2">নাগরিক সেবা</h6>
                    <small class="text-muted">সহজে আবেদন</small>
                </div>
                <div class="col-md-3 col-6">
                    <i class="bi bi-credit-card text-warning fs-1"></i>
                    <h6 class="mt-2">অনলাইন পেমেন্ট</h6>
                    <small class="text-muted">বিকাশ/নগদ</small>
                </div>
                <div class="col-md-3 col-6">
                    <i class="bi bi-qr-code text-info fs-1"></i>
                    <h6 class="mt-2">QR যাচাই</h6>
                    <small class="text-muted">সহজে verify</small>
                </div>
            </div>
        </div>
    </section>

    
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-1">
                &copy; <?php echo e(date('Y')); ?> <?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?>

            </p>
            <small class="text-muted">
                <?php if(current_union()?->phone): ?>
                    <i class="bi bi-telephone"></i> <?php echo e(current_union()->phone); ?>

                <?php endif; ?>
                <?php if(current_union()?->email): ?>
                    | <i class="bi bi-envelope"></i> <?php echo e(current_union()->email); ?>

                <?php endif; ?>
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH R:\xampp\htdocs\union-porishod\resources\views/welcome.blade.php ENDPATH**/ ?>