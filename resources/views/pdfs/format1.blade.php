<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Regular Single Voucher</title>

    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        *:before,
        *:after {
            box-sizing: inherit;
        }

        p {
            font-size: 10px;
            font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
            line-height: 1;
        }

        h2 {
            font-family: Calibri, Arial, sans-serif;
            font-size: 27px;
            line-height: 1;
        }

        table,
        th,
        td {
            padding: 10px;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .flex-container {
            display: block;
            background-color: #ffffff;
        }

        .flex-container>.card {
            float: left;
            background-color: #ffffff;
            width: 360px;
            height: 240px;
            margin: 5px;
            -webkit-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            -moz-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            -ms-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            -o-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        }

        .flex-container .row {
            padding-left: 15px;
            padding-right: 15px;
            margin: 15px 0;
        }

        .flex-container .col {
            width: 180px;
            max-width: 50%;
            float: left;
        }

        .fix {
            clear: both;
        }

        img {
            width: 180px;
            margin-top: 6px;
        }

        .col h4 {
            font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;
            font-weight: 500;
            font-size: 17px;
        }

        .bg-green {
            background-color: #00b050;
            width: 100%;
            padding: 7px;
            text-align: center;
        }

        .bg-green h4 {
            color: #ffffff;
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>
</head>

<body>
    
    <div class="flex-container">
        <div class="card">
            <div class="row">
                <h2>1234 {{ $data['first_name'] }}, {{ $data['last_name'] }}</h2>
            </div>
            <div class="row">
                <div class="col">
                    <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg">
                </div>
                <div class="col">
                    <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg">
                </div>
                <div class="fix"></div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Save $5 Weekdays</h4>
                    <h4>(open til 3PM)</h4>
                </div>
                <div class="col">
                    <h4>Save $10 Weekends &</h4>
                    <h4>Holidays (7am to 3pm)</h4>
                </div>
                <div class="fix"></div>
            </div>
            <div class="row">
                <p>- Valid May 11 to Oct 12, 2020</p>
                <p>- Cannot be used with Tournament play or combined with other offers</p>
                <p>- Each person must provide either their personalized paper or phone voucher</p>
            </div>
        </div>
        
        <div class="card">
            <div class="row">
                <h2>1234 {{ $data['first_name'] }}, {{ $data['last_name'] }}</h2>
            </div>
            <div class="row">
                <div class="col">
                    <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg">
                </div>
                <div class="col">
                    <img src="https://www.burlingtonsprings.com/wp-content/uploads/sites/6313/2017/04/logo.jpg">
                </div>
                <div class="fix"></div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Save $5 Weekdays</h4>
                    <h4>(open til 3PM)</h4>
                </div>
                <div class="col">
                    <h4>Save $10 Weekends &</h4>
                    <h4>Holidays (7am to 3pm)</h4>
                </div>
                <div class="fix"></div>
            </div>
            <div class="row">
                <p>- Valid May 11 to Oct 12, 2020</p>
                <p>- Cannot be used with Tournament play or combined with other offers</p>
                <p>- Each person must provide either their personalized paper or phone voucher</p>
            </div>
        </div>
        
    </div>
    <div class="fix"></div>


    
</body>

</html>