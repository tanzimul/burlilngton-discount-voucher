<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Regular Discount Voucher</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Calibri';
            font-weight: normal;
            src: url({{ storage_path('fonts/calibri.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Calibri Bold';
            font-weight: normal;
            src: url({{ storage_path('fonts/calibrib.ttf') }}) format('truetype');
        }
    </style>
</head>

<body>
    <table cellspacing="4" cellpadding="0" border="0" align="center" style="width:380px;" bgcolor="#FFFFFF">
        <tr>
            <td align="center" valign="middle">
                <table cellspacing="0" cellpadding="0" border="0" align="center" style="width:100%;border:1px solid #000000;" bgcolor="#FFFFFF">
                    <tr>
                        <td colspan="2" align="left" valign="middle" style="padding:5px;">
                            <p style="font-family:Calibri Bold,sans-serif;font-size: 26px;line-height: 26px;margin:0;padding:0;">{{ $data['discountCode'] }} {{ $data['first_name'] }}, {{ $data['last_name'] }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" style="padding:5px;">
                            <img src="{{ public_path().'/images/logo.png' }}" width="140" height="60" />
                        </td>
                        <td align="center" valign="middle" style="padding:5px;">
                            <img src="{{ public_path().'/images/senior-button.png' }}" width="130" height="40" />
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" style="padding:5px;">
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">Monday-Friday til 3pm</p>
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">$36.50 + HST - Walking</p>
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">$49.50 + HST - Riding</p>
                        </td>
                        <td align="left" valign="middle" style="padding:5px;">
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">Weekends & Holidays</p>
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">7am to 3pm</p>
                            <p style="font-family:Calibri,sans-serif;font-size:17px;line-height:1;margin:0;padding:0;">Save $10 on green fee</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" valign="middle" style="padding:5px;">
                            <p style="font-family:Calibri,sans-serif;font-size: 10px;line-height:10px;margin:0;padding:0;">- Valid May 11 to Oct 12, 2020</p>
                            <p style="font-family:Calibri,sans-serif;font-size: 10px;line-height:10px;margin:0;padding:0;">- Cannot be used with Tournament play or combined with other offers</p>
                            <p style="font-family:Calibri,sans-serif;font-size: 10px;line-height:10px;margin:0;padding:0;">- Each person must provide either their personalized paper or phone voucher</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>