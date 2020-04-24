<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Redemption Transactions</title>
    <style>
        table,
        th,
        td {
            padding: 10px;
            border: 1px solid black;
            border-collapse: collapse;
        }
        h1{
            text-align: center;
        }
    </style>
</head>

<body>
    
    <table>
        <thead>
            <tr>
                <th colspan="4" style="text-align: center"><h1>Redemption Transactions from {{ $from }} to {{ $to }}</h1></th>
            </tr>
            <tr>
                <th>#SL</th>
                <th>Email</th>
                <th>Membership Type</th>
                <th>Discount Voucher Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $key => $discount)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $discount->memberData->email }}</td>
                <td>{{ $discount->membership_type }}</td>
                <td>{{ $discount->discount_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>