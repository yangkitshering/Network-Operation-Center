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
    @if($status == 1)
    {{-- <p> &nbsp;{{ 'Please produce your approval note during the time of your visit.' }}</p> --}}

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{route('approval.process')}}" class="btn btn-info btn-sm" target="_blank">
        <i class="far fa-edit"></i>
        &#x2192;Click here to Login</a>
    @endif
    <br>
    <br>
</body>
<p> Regards</p>
<p> Thank you</p>
</body>

</html>