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
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Dear {{ $data['first_name'] }} {{ $data['last_name'] }},</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Welcome to the Burlington Springs personalized Daily Discount Program. We are excited to offer you reduced golf rates for your ongoing loyalty!</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Your enrolled Name and Daily Discount # {{ $data['discountCode'] }} are printed on the attached personalized vouchers… and one is required for each golfer who wishes the discount.</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">In these challenging times we have also upgraded our program with reduced physical contact options that enhance everyone’s safety. You can use ONE of the following options that best suits you: </p>
        <ol>
            <li>
                <p style="font-size: 15px;margin-bottom: 0.2rem;">The new “paperless” option where you save your personalized voucher to your phone*. You show your phone voucher to our pro shop rep on each visit</p>
            </li>
            <li>
                <p style="font-size: 15px;margin-bottom: 0.2rem;">The new “paper” option where you print and reuse one personalized voucher. You show the paper voucher to our pro shop rep on each visit</p>
            </li>
            <li>
                <p style="font-size: 15px;margin-bottom: 0.2rem;">The existing “paper” option where you print and hand over a personalized voucher. You clip out one voucher from the new 8 voucher page and hand it to the pro shop rep on each visit</p>
            </li>
        </ol>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Daily Discount Program usage conditions are described on the vouchers and on our website. If you require any clarification, please ask our pro shop team.</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;">Thank you for enrolling in our program – we look forward to seeing you regularly at Burlington Springs and please let us know how we can improve your experience.</p>
        <p style="font-size: 15px;margin-bottom: 0;">Regards,</p>
        <p style="font-size: 15px;margin-bottom: 1.2rem;"><strong>The Burlington Springs Team</strong></p>

        <p style="font-size: 15px;margin-bottom: 0.2rem;">* For the “paperless” option, please save the attached ‘single voucher’ to your phone so you can present it on each visit to show to the pro shop team.  One easy way to do this is to install a simple Android or iPhone wallet app, save only our voucher to the app, and effectively use it as your “Burlington Springs Voucher” app.</p>
        <p style="font-size: 15px;margin-bottom: 0.2rem;">Please go to <a href="https://www.burlingtonsprings.com/daily-discount/" target="_blank">Daily Discount Program</a> to see apps that we recommend that suit this need.</p>
        <p style="font-size: 15px;margin-bottom: 0.2rem;">If you did not request this email, please advise us by forwarding this email to <a href="mailto:burlingtonsprings@gmail.com">burlingtonsprings@gmail.com</a></p>
    </div>
</body>

</html>