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
    <h2>Burlington Springs Daily Discount Program – Daily Redemptions</h2>
    <h4>Date : {{ $date }}</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th><strong>Paper</strong></th>
                <th><strong>Phone</strong></th>
                <th><strong>Total</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Regular</strong></td>
                <td>{{ $paperRegularCount }}</td>
                <td>{{ $phoneRegularCount }}</td>
                <td>{{ $sumOfRegular }}</td>
            </tr>
            <tr>
                <td><strong>Senior</strong></td>
                <td>{{ $paperSeniorCount }}</td>
                <td>{{ $phoneSeniorCount }}</td>
                <td>{{ $sumOfSenior }}</td>
            </tr>
            <tr>
                <td><strong>Frequent Flyer</strong></td>
                <td></td>
                <td></td>
                <td>{{ $sumOfFlyer }}</td>
            </tr>


        </tbody>
        <tfoot>
            <tr>
                <th><strong>Total</strong></th>
                <th>{{ $totalPaper }}</th>
                <th>{{ $totalPhone }}</th>
                <th>{{ $subTotal }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>