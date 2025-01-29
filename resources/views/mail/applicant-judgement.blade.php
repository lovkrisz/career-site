<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
Hi {{ $applicant->name }}, <br>

<p>
    Your application has been reviewed and the result is as follows:
</p>
<p>
    <strong>Result:</strong> {{ $status }}
</p>

@if($url != "")
    <p>
        <a href="{{ $url }}">Click here to reserve time for your interview</a>
    </p>
@endif
</body>
</html>
