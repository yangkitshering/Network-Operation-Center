<!DOCTYPE html>
<html>

<head>
    <title>Approval PDF</title>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            /* changes */
            background-color: lightgray;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
            /* changes */
            border: 1px solid gray;
        }

        .logo {
            display: inline-block;
            margin-right: auto;
            padding: 10px 0;
        }

        .logo img {
            height: 50px;
            width: auto;
        }


        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;

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

        .header {
            position: absolute;
            top: 50px;
            right: 50px;
            font-size: 14px;
            color: #888;
        }

        .images-container {
            display: flex;
            flex-direction: column-reverse;
            /* Stack images from bottom to top */
            align-items: flex-end;
            /* Align images to the right side */
            gap: 10px;
            /* Add some spacing between images */
        }

        .passport-image {
            height: 100px;
            width: 100px;
        }

        .light-hr {
            border-color: #ccc;
            /* Set the border color to a lighter shade */
        }
    </style>
</head>

<body>
    <br><br>

    <div class="container">
        <div class="header">
            Approval letter| Bhutan Telecom
        </div>
        <div class="logo">
            <img src="{{ public_path('/images/logo.png') }}" alt="Logo">

        </div>
        {{-- <h1>Hello {{ $approval->name }}</h1> --}}
        <h1>Visitors e-Card</h1>


        <table style="width: 100%;">

            <td style="width: 80%;">
                <div class="details">
                    <h2>Visitor Details:</h2>
                    <p><strong>Name:</strong> {{ $approval->name }}</p>
                    <p><strong>CID:</strong> {{ $approval->cid }}</p>
                    <p><strong>Organization:</strong> {{ $org_name }}</p>
                    <p><strong>Email:</strong> {{ $approval->email }}</p>
                    <p><strong>Contact:</strong> {{ $approval->contact }}</p>
                    <p><strong>Approxiate Date & Time :</strong></p>
                    <p><strong>From: </strong> {{ $approval->visitFrom }} &nbsp;<strong>To: </strong> {{
                        $approval->visitTo }}</p>
                    <p><strong>Purpose of visit:</strong> {{ $approval->reason }}</p>
                    <br>
                    @if(count($additional_user) != 0)
                    <p><strong>Additional Visitors Details:</strong> </p>
                    @foreach($additional_user as $user)
                    <p><b>Name:</b> {{ $user->name }}, <b>CID:</b> {{ $user->cid }}, <b>Organization:</b> {{
                        $user->organization }}</p>
                    @endforeach
                    @endif

                    <p><strong>Remark*</strong><i> Kindly produce your individual CID during your visit.</i></p>
                </div>
                <p>Approved By:</p>
                <p>NOC Manager</p>
                <br>
                <hr class="light-hr">

                <p><strong>Focal Person:</strong> </p>
                <p><strong>Name:</strong> {{ $approval->focal_person }},
                    &nbsp;<strong>Contact:</strong> {{ $approval->focal_contact }}</p>


                <p><b>Note*</b><i>Kindly notify the on-duty NOC staff when you exit NOC room. Failure to do so may
                        result in your
                        continued presence being assumed in the NOC room, and you may be held accountable for any
                        misshaps
                        in the equipment room during this period.</i></p>
            </td>

            <td style="width: 0%;">

                <div>

                </div>
            </td>
            <td style="width: 20%;">

                <div class="images-container">
                    @foreach(explode(',', $approval->passport_path) as $filePath)
                    <img src="{{ public_path('/storage/'. trim($filePath)) }}" class="passport-image"
                        alt="Passport Photo">
                    @endforeach
                </div>
            </td>
        </table>


</body>

</html>