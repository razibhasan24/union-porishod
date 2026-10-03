<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ধরন অনুযায়ী রিপোর্ট</title>
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
        <p>ধরন অনুযায়ী রিপোর্ট — {{ bangla_date($data['start']) }} থেকে {{ bangla_date($data['end']) }}</p>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>ধরন</th>
            <th class="text-end">মোট আবেদন</th>
            <th class="text-end">অনুমোদিত</th>
            <th class="text-end">বাতিল</th>
            <th class="text-end">আয় (৳)</th>
        </tr>
        @foreach($data['data'] as $i => $row)
        <tr>
            <td>{{ bangla_number($i + 1) }}</td>
            <td>{{ $row['type']->name_bn }}</td>
            <td class="text-end">{{ bangla_number($row['total_applications']) }}</td>
            <td class="text-end">{{ bangla_number($row['approved']) }}</td>
            <td class="text-end">{{ bangla_number($row['rejected']) }}</td>
            <td class="text-end">{{ bangla_number(number_format($row['revenue'], 0)) }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>