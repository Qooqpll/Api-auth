<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="signup-wrapper">
    <h1>Registration</h1>

    <form action="" method="post" class="form_reg">
        <label for="domain">domain</label>
        <input type="text" name="domain" class="domain">

        <label for="login">login</label>
        <input type="text" name="login" class="login"/>

        <label for="password">password</label>
        <input type="password" name="password" class="password"/>

        <label for="repeat_password">repeat password</label>
        <input type="password" name="repeat_password" class="repeat_password"/>

        <label for="remember_me">remember_me</label>
        <input type="checkbox" name="remember_me" class="remember_me">

        <button type="button" class="submitReg">sign up</button>
    </form>
</div>

<div class="signin-wrapper" style="display: none">
    <h1>Auth</h1>

    <form action="" method="post" class="form_auth">
        <label for="domain">domain</label>
        <input type="text" value="1" name="domain" class="domain">

        <label for="login">login</label>
        <input type="text" name="login" class="login"/>

        <label for="password">password</label>
        <input type="password" name="password" class="password"/>

        <label for="remember_me">remember_me</label>
        <input type="checkbox" name="remember_me" class="remember_me">

        <button type="button" class="submitAuth">sign in</button>

    </form>
</div>

<button class="toggle" value="1">signin</button>

<div class="error">
    <span></span>
</div>

<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

<script src="script.js">

</script>
<script src="validate.js">

</script>

</body>
</html>