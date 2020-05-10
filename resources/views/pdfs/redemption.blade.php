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
    <h1>Redemption Transactions from {{ $from }} to {{ $to }}</h1>
    <table>
        <thead>
            <tr>
                <th>#SL</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Membership Type</th>
                <th>Discount #</th>
                <th>Transactions Confirmed by Phone</th>
                <th>Date of Redemption</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $key => $discount)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $discount->memberData->first_name }}</td>
                <td>{{ $discount->memberData->last_name }}</td>
                <td>{{ $discount->memberData->email }}</td>
                <td>{{ $discount->memberData->membership_type }}</td>
                <td>{{ $discount->memberData->discount_id }}</td>
                <td>
                    @if ($discount->memberData->device == 'phone' && $discount->memberData->is_admin == false) 
                    Yes
                    @else
                    No
                    @endif
                </td>
                <td>{{ $discount->last_used_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>