<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>মাসিক রিপোর্ট</title>
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
        <p>মাসিক রিপোর্ট — {{ $data['month_name'] }} {{ bangla_number($data['year']) }}</p>
    </div>

    <table>
        <tr><th>বিবরণ</th><th class="text-end">সংখ্যা</th></tr>
        <tr><td>মোট আবেদন</td><td class="text-end">{{ bangla_number($data['applications']) }}</td></tr>
        <tr><td>অনুমোদিত</td><td class="text-end">{{ bangla_number($data['approved']) }}</td></tr>
        <tr><td>বাতিল</td><td class="text-end">{{ bangla_number($data['rejected']) }}</td></tr>
        <tr><th>মোট আয়</th><th class="text-end">৳ {{ bangla_number(number_format($data['revenue'], 0)) }}</th></tr>
    </table>

    <h3 style="margin-top:20px;">ধরন অনুযায়ী</h3>
    <table>
        <tr><th>ধরন</th><th class="text-end">সংখ্যা</th></tr>
        @foreach($data['by_type'] as $row)
        <tr><td>{{ $row['name'] }}</td><td class="text-end">{{ bangla_number($row['total']) }}</td></tr>
        @endforeach
    </table>

    <h3 style="margin-top:20px;">ওয়ার্ড অনুযায়ী</h3>
    <table>
        <tr><th>ওয়ার্ড</th><th class="text-end">সংখ্যা</th></tr>
        @foreach($data['by_ward'] as $row)
        <tr><td>{{ $row['name'] }}</td><td class="text-end">{{ bangla_number($row['total']) }}</td></tr>
        @endforeach
    </table>
</body>
</html>