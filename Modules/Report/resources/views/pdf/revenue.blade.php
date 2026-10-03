<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>আয়ের রিপোর্ট</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #0a4d8c; }
        .header { text-align: center; border-bottom: 2px solid #0a4d8c; padding-bottom: 10px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #0a4d8c; color: white; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}</h2>
        <p>আয়ের রিপোর্ট — {{ bangla_date($data['start']) }} থেকে {{ bangla_date($data['end']) }}</p>
    </div>

    <table>
        <tr><th>বিবরণ</th><th class="text-end">পরিমাণ</th></tr>
        <tr><td>মোট আয়</td><td class="text-end">৳ {{ bangla_number(number_format($data['total_revenue'], 0)) }}</td></tr>
        <tr><td>অনলাইন</td><td class="text-end">৳ {{ bangla_number(number_format($data['by_method']['online'], 0)) }}</td></tr>
        <tr><td>নগদ</td><td class="text-end">৳ {{ bangla_number(number_format($data['by_method']['cash'], 0)) }}</td></tr>
        <tr><th>নেট আয়</th><th class="text-end">৳ {{ bangla_number(number_format($data['net_revenue'], 0)) }}</th></tr>
    </table>

    <h3 style="margin-top:20px;">দিন অনুযায়ী</h3>
    <table>
        <tr><th>তারিখ</th><th class="text-end">আয় (৳)</th></tr>
        @foreach($data['by_day'] as $row)
        <tr><td>{{ bangla_date($row->date) }}</td><td class="text-end">{{ bangla_number(number_format($row->total, 0)) }}</td></tr>
        @endforeach
    </table>
</body>
</html>