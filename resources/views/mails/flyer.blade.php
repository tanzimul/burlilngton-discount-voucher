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
    </style>
</head>

<body>
    <div style="width: 768px; margin:0 auto;">
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Dear {{ $data['first_name'] }} {{ $data['last_name'] }},</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Welcome to the Burlington Springs personalized Frequent Flyer Program.  We are excited to offer you reduced golf rates for your ongoing loyalty!</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">We have assigned you Discount # {{ $data['discountCode'] }} that will be required along with your Last Name by our Pro Shop team each time you play.  The number is associated with your email address and is not transferable to other golfers.</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Reduced rates are offered May 11th to Oct 12th, 2020 and cannot be used with Tournament play or combined with other offers.</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Thank you for patronage, we look forward to seeing you regularly at Burlington Springs and please let us know how we can improve your experience. Please retain this email for your records.</p>
        
        <p style="font-size: 15px;margin-bottom: 0;">Regards,</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;"><strong>The Burlington Springs Team</strong></p>

        <p style="font-size: 15px;margin-bottom: 0.2rem;">* For easy access you may wish to store a photo or screen shot of the top portion of this confirmation email. Install a simple Android or iPhone wallet app, save this photo or screenshot to the app, and effectively use it as your “Burlington Springs” app.</p>
        <p style="font-size: 15px;margin-bottom: 0.2rem;">Please go to <a href="https://www.burlingtonsprings.com" target="_blank">Daily Discount Program</a> to see apps that we recommend that suit this need.</p>
        <p style="font-size: 15px;margin-bottom: 0.2rem;">If you did not request this email, please advise us by forwarding this email to <a href="mailto:burlingtonsprings@gmail.com">burlingtonsprings@gmail.com</a></p>
    </div>
</body>

</html>