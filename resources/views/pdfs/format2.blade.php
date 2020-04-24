<!DOCTYPE html>
<html lang="en" >

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>First Laravel DOM PDF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Calibri';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/calibri.ttf') }}") format('truetype');
        }
    </style>
</head>

<body>
    <table style="border-collapse: collapse;table-layout: fixed;width: 360px;box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);">
        <tr>
            <td colspan="2" style="padding: 10px;">
                <h2 style="font-family: Calibri, Arial, sans-serif;font-size: 27px;line-height: 1;">1234 Tanzimul, Tanim</h2>
            </td>
        </tr>
        <tr>
            <td>
                <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg" width="180">
            </td>
            <td>
                <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg" width="180">
            </td>
        </tr>
        <tr>
            <td style="padding: 10px;">
                <h4 style="font-family: Calibri, Arial, sans-serif;font-weight: 500;font-size: 17px;">Save $5 Weekdays</h4>
                <h4 style="font-family: Calibri, Arial, sans-serif;font-weight: 500;font-size: 17px;">(open til 3PM)</h4>
            </td>
            <td style="padding: 10px;">
                <h4 style="font-family: Calibri, Arial, sans-serif;font-weight: 500;font-size: 17px;">Save $10 Weekends &</h4>
                <h4 style="font-family: Calibri, Arial, sans-serif;font-weight: 500;font-size: 17px;">Holidays (7am to 3pm)</h4>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 10px;">
                <p style="font-family: Calibri, Arial, sans-serif;font-size: 10px;margin:0;">- Valid May 11 to Oct 12, 2020</p>
                <p style="font-family: Calibri, Arial, sans-serif;font-size: 10px;margin:0;">- Cannot be used with Tournament play or combined with other offers</p>
                <p style="font-family: Calibri, Arial, sans-serif;font-size: 10px;margin:0;">- Each person must provide either their personalized paper or phone voucher</p>
            </td>
        </tr>
    </table>
</body>

</html>