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
    <br><br>

    <div class="container">
        <h1>Hello {{ $usr->name }}</h1>
        <p>Your request has been approved. Please produce this documents during your visit.</p>

        <div class="details">
            <h2>Visitor Details:</h2>
            <p><strong>Name:</strong> {{ $usr->name }}</p>
            <p><strong>CID:</strong> {{ $usr->cid }}</p>
            <p><strong>Organization:</strong> {{ $org_name }}</p>
            <p><strong>Contact:</strong> {{ $usr->contact }}</p>
        </div>
    </div>
</body>

</html>