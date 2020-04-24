<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Redemption Transactions</title>
    <style>
        table,
        th,
        td {
            padding: 10px;
            border: 1px solid black;
            border-collapse: collapse;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th colspan="4" style="text-align: center">
                    <h2>Burlington Springs Daily Discount Program – Daily Redemptions</h2>
                    <h4>Date : {{ $date }}</h4>
                </th>
            </tr>
            <tr>
                <th></th>
                <th>Paper</th>
                <th>Phone</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Regular</td>
                <td>{{ $paperRegularCount }}</td>
                <td>{{ $phoneRegularCount }}</td>
                <td>{{ $sumOfRegular }}</td>
            </tr>
            <tr>
                <td>Senior</td>
                <td>{{ $paperSeniorCount }}</td>
                <td>{{ $phoneSeniorCount }}</td>
                <td>{{ $sumOfSenior }}</td>
            </tr>
            <tr>
                <td>Frequent Flyer</td>
                <td></td>
                <td></td>
                <td>{{ $sumOfFlyer }}</td>
            </tr>
            <tr>
                <td>Admin 9999*</td>
                <td></td>
                <td></td>
                <td>{{ $sumOfAdminDiscount }}</td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th>{{ $totalPaper }}</th>
                <th>{{ $totalPhone }}</th>
                <th>{{ $subTotal }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>