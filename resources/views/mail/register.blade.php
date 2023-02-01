<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
<h1>You Have A Mail To Confirm Register</h1>
<p>Please click link to Confirm Register</p>
<p>this link will not be available after 15 minutes</p>
<a href="{{ route('register.confirm', $token) }}">link to confirm</a>
</body>
</html>
