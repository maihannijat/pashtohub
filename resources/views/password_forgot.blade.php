<!DOCTYPE html>
<html>
<head>
</head>

<body style="border: 1px solid lightgray;">
<div style="height: 120px; background:white;"></div>
<div style="background:#eff0f2; padding: 40px;">
    <p>Hello {{$user->first_name}} {{$user->last_name}},</p>
    <p>
        You told us you forgot your password. If you really did, click here to choose a new one:
    </p>
    <a href="http://localhost:4200/users/reset/{{$user->first_name}}/{{$user->last_name}}/{{$token}}">
        <button style="height: 45px; width:200px; background: #009688; color:white; font-size: 14px; border-radius: 5px;">
            Choose a new password
        </button>
    </a>
    <p>
        If you didn't mean to reset your password, then you can just ignore this email; your password will not change.
    </p>
</div>
<div style="height: 80px; background:white; padding:20px; text-align: center">
    <p>Pashto Hub</p>
    <p>www.pashto.io</p>
</div>
</body>
</html>