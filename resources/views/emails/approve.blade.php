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
    <p>&nbsp;{{ $mail_data['body'] }}</p>
    <br>

    @if($status == 'A')
    <p>&nbsp; Please click on the link below once you exited from the server room.</p>
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{route('exit',$id)}}" class="btn btn-info btn-sm" target="_blank">
        <i class="far fa-edit"></i>
        &#x2192;Click here on your exit</a>
    @endif

    <p> Thank you</p>
</body>

</html>