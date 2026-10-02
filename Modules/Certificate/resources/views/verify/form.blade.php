<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>সার্টিফিকেট যাচাই</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'SolaimanLipi', 'Segoe UI', sans-serif;
        }
        .verify-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="verify-card">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-primary" style="font-size: 40px;"></i>
                        </div>
                        <h3 class="text-primary">সার্টিফিকেট যাচাই</h3>
                        <p class="text-muted">সার্টিফিকেট নম্বর বা ভেরিফিকেশন কোড দিন</p>
                    </div>

                    <form method="GET" action="{{ route('verify.form') }}"
                          onsubmit="event.preventDefault(); const code = this.code.value.trim(); if (code) window.location.href = '/verify/certificate/' + encodeURIComponent(code);">
                        <div class="mb-3">
                            <input type="text" id="code" name="code" class="form-control form-control-lg"
                                   placeholder="সার্টিফিকেট নম্বর / Verification Code"
                                   required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search"></i> যাচাই করুন
                        </button>
                    </form>

                    <div class="alert alert-info small mt-3 mb-0">
                        <i class="bi bi-info-circle"></i>
                        সার্টিফিকেটের QR কোড স্ক্যান করলেও সরাসরি যাচাই করা যাবে।
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>