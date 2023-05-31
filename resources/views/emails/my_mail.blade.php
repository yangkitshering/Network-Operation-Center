<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NOC server access</title>
</head>

<body>
    <h4>{{ $mail_data['title'] }}</h4>
    <p>{{ $mail_data['body'] }}</p>
    <p>{{ 'Please click below to approve or reject' }}</p>
    <br>
    {{-- <a href="{{ route('approval.process') }}">Approve/Reject</a> --}}
    <a href="{{ route('approval.process') }}" class="btn btn-success btn-sm">
        <i class="far fa-edit"></i>
        Approve/Reject</a>

    <p> Thank you</p>
</body>

</html>