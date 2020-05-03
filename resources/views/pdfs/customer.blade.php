<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Customer List</title>
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
    <h1>Customer List</h1>
    <table>
        <thead>
            <tr>
                <th>#SL</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Membership Type</th>
                <th>Discount #</th>
                <th>Created At</th>
                <th>Updated At</th>
                

            </tr>
        </thead>
        <tbody>
            @foreach($customers as $key => $customer)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $customer->first_name }}</td>
                <td>{{ $customer->last_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->membership_type }}</td>
                <td>{{ $customer->discount_id }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>{{ $customer->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>