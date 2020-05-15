<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <a href="/forgot-password">Password dimenticata</a>

    <?php if($token): ?>
        <form action="/change-password" method="post">
            <input type="token" name="token" value="<?php echo $token; ?>">
            <input type="password" name="password" placeholder="Password">
            <button>Accedi</button>
        </form>
    <?php else: ?>
        <form action="/login" method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button>Accedi</button>
        </form>
    <?php endif; ?>
     
</body>
</html>