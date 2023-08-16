<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New User Approval</title>
</head>

<body>
    <h4>{{ $mail_data['title'] }}</h4>
    <p> &nbsp;{{ $mail_data['body'] }}</p>
    <p> &nbsp;{{ 'Kindly click on the button for approval.' }}</p>
    <br>
    {{-- <a href="{{ route('approval.process') }}" class="btn btn-success btn-sm">
        <i class="far fa-edit"></i>
        Approve/Reject</a> --}}
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('newUser.approval') }}" target="_blank"
        style="background-color: #4ca8af; color: white; padding: 15px 25px; text-align: center; display: inline-block; text-decoration: none; font-size: 16px; border-radius: 4px; border: none;">{{
        __('Login to approve') }}</a>
</body>
<p> Regards</p>
<p> Thank you</p>
</body>

</html>