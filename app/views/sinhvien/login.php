<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Login </h1>
    <form action="/QLSV/public/auth/login" method="POST">
        <Label>UserName: </Label>
        <input type="text" name="username" placeholder="userName"> <br>
        <Label>Password: </Label>
        <input type="text" name="password" placeholder="password"> <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>