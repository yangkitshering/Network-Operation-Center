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
            display: flex;
            flex-direction: row-reverse;
            /* Display image on the right */
            align-items: flex-start;
            /* Align items to the top */
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

        .text {
            padding-left: 20px;
            /* Adjust padding to create spacing between logo and text */
            text-align: left;
        }

        .text h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .text p {
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

        .user-image {
            text-align: right;
        }

        .user-image img {
            height: 100px;
            width: 100px;
        }
    </style>
</head>

<body>
    <br><br>

    <div class="container">
        <div class="logo">
            <img src="{{ public_path('/images/logo.png') }}" alt="Logo">

        </div>

        <table style="width: 100%;">
            <td style="width: 100%;">

                <table style="width: 100%;">
                    <td style="width: 50%;">

                        <h1>{{ $usr->name }}</h1>



                        <div class="details">


                            <p><strong>Username: </strong> {{ $usr->name }}</p>

                            <p><strong>Email: </strong> {{ $usr->email }}</p>

                            <p><strong>CID: </strong> {{ $usr->cid }}</p>

                            <p><strong>Organization: </strong> {{ $org_name }}</p>

                        </div>
                    </td>
                    {{-- <td style="width: 50%;">
                        <div class="user-image">
                            <img src="{{ public_path("/storage/". $file_path) }}" alt="User Image">
                        </div>
                    </td> --}}
                </table>

    </div>


    </div>
</body>

</html>