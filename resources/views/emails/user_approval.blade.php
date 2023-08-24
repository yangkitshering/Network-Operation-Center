<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New User Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .details {
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .details p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h5>&nbsp;{{ $mail_data['title'] }}</h5>
    <p> &nbsp;{{ $mail_data['body'] }}</p>
    {{-- <p> &nbsp;{{ 'Registration Details as Follows:' }}</p> --}}
    {{-- <br> --}}
    <div class="details">
        {{-- <h5>&nbsp; Registration Details as Follows:</h5> --}}
        <p>&nbsp;<strong>Name:</strong>{{$mail_data['name']}}</p>
        <p>&nbsp;<strong>CID:</strong>{{$mail_data['cid']}}</p>
        <p>&nbsp;<strong>Organization:</strong>{{$mail_data['organization']}}</p>
        <p>&nbsp;<strong>Email:</strong>{{$mail_data['email']}}</p>
        <p>&nbsp;<strong>Contact No:</strong>{{$mail_data['contact']}}</p>
    </div>

    &nbsp;<a href="{{ route('newUser.approval') }}" target="_blank"
        style="background-color: #4ca8af; color: white; padding: 15px 25px; text-align: center; display: inline-block; text-decoration: none; font-size: 16px; border-radius: 4px; border: none;">{{
        __('Login to portal for approval') }}</a>
</body>
<p> Regards</p>
<p> Thank you</p>
</body>

</html>