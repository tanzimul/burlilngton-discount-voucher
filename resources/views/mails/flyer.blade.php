<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burlington Springs</title>
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

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        ol,
        ul {
            margin: 0;
            padding: 0;
            font-weight: normal;
        }

        p {
            font-size: 15px;
            margin-bottom: 1.2rem;
        }

        ol {
            padding-left: 25px;
            padding-bottom: 25px;
        }
    </style>
</head>

<body>
    <div style="width: 768px; margin:0 auto;">
        <p>Dear {{ $data['first_name'] }} {{ $data['last_name'] }},</p>
        <p>Welcome to the Burlington Springs personalized Frequent Flyer Program.  We are excited to offer you reduced golf rates for your ongoing loyalty!</p>
        <p>We have assigned you Discount # @foreach ($data['discountCodes'] as $key => $code) {{ $code }} @if (!$loop->last), @endif @endforeach that will be required along with your Last Name by our Pro Shop team each time you play.  The number is associated with your email address and is not transferable to other golfers.</p>
        <p>Reduced rates are offered May 11th to Oct 12th, 2020 and cannot be used with Tournament play or combined with other offers.</p>
        <p>Thank you for patronage, we look forward to seeing you regularly at Burlington Springs and please let us know how we can improve your experience. Please retain this email for your records.</p>
        
        <p>Regards,</p>
        <p>The Burlington Springs Team</p>

        <p>* For easy access you may wish to store a photo or screen shot of the top portion of this confirmation email. Install a simple Android or iPhone wallet app, save this photo or screenshot to the app, and effectively use it as your “Burlington Springs” app.</p>
        <p>Please go to <a href="https://www.burlingtonsprings.com" target="_blank">Daily Discount Program</a> to see apps that we recommend that suit this need.</p>
        <p>If you did not request this email, please advise us by forwarding this email to <a href="mailto:burlingtonsprings@gmail.com">burlingtonsprings@gmail.com</a></p>
    </div>
</body>

</html>