<!DOCTYPE html>
<html>

<head>
    <title>Approval PDF</title>
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
            text-align: left;
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
            border-top: 0px solid #ccc;
            padding-top: 10px;
        }

        .details p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <br><br>

    <div class="container">
        <div class="logo">
            <img src="{{ public_path('/images/logo.png') }}" alt="Logo">

        </div>

        <h1>Hello {{ $approval->name }}</h1>
        <p>We are pleased to inform you that your request has been officially approved. In preparation for your
            scheduled visit, we kindly request you to bring the confirmation document along with you.
            These documents are essential to ensure a seamless and efficient experience during your upcoming visit</p>


        <div class="details">
            <h2>Visitor Details:</h2>
            <p><strong>Name:</strong> {{ $approval->name }}</p>
            <p><strong>CID:</strong> {{ $approval->cid }}</p>
            <p><strong>Organization:</strong> {{ $org_name }}</p>
            <p><strong>Email:</strong> {{ $approval->email }}</p>
            <p><strong>Contact:</strong> {{ $approval->contact }}</p>
            <p><strong>Approxiate time of visit:</strong></p>
            <p><strong>From: </strong> {{ $approval->visitFrom }}</p>
            <p><strong>To: </strong> {{ $approval->visitTo }}</p>
            <p><strong>Purpose of visit:</strong> {{ $approval->reason }}</p>


            {{-- <img src="{{ asset('storage/'. $usr->cid_path) }}" height="300" width="300" alt="User Image"> --}}
            {{-- src="public/images/thumb.png" --}}
        </div>
        <p>Approved By:</p>
        <p>NOC Manager</p>


    </div>
</body>

</html>