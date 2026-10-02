<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — <?php echo e(current_union()?->name_bn ?? config('app.name')); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', 'SolaimanLipi', Tahoma, sans-serif; }
        .hover-bg { transition: all 0.2s; }
        .hover-bg:hover { background-color: rgba(13,110,253,0.08); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo e(route('applicant.dashboard')); ?>">
                <?php if(current_union()?->logo): ?>
                    <img src="<?php echo e(asset('storage/' . current_union()->logo)); ?>" width="32" height="32"
                         class="me-2 rounded bg-white p-1" alt="Logo">
                <?php endif; ?>
                <?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?>

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('applicant.dashboard') ? 'active' : ''); ?>"
                           href="<?php echo e(route('applicant.dashboard')); ?>">
                            <i class="bi bi-speedometer2"></i> ড্যাশবোর্ড
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('applicant.applications.*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('applicant.applications.index')); ?>">
                            <i class="bi bi-file-earmark-text"></i> আমার আবেদন
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('applicant.applications.create')); ?>">
                            <i class="bi bi-plus-circle"></i> নতুন আবেদন
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                           data-bs-toggle="dropdown">
                            <img src="<?php echo e(auth()->user()->photo_url ?? asset('images/default-avatar.png')); ?>"
                                 width="32" height="32"
                                 class="rounded-circle me-2" style="object-fit: cover;">
                            <span><?php echo e(auth()->user()->display_name); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('applicant.profile.edit')); ?>">
                                    <i class="bi bi-person"></i> প্রোফাইল
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> লগআউট
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="text-center text-muted py-3 small border-top bg-white mt-5">
        &copy; <?php echo e(date('Y')); ?> <?php echo e(current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ'); ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH R:\xampp\htdocs\union-porishod\Modules/Applicant\resources/views/layouts/app.blade.php ENDPATH**/ ?>