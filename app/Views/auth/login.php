<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; }
        .container { max-width: 400px; margin: 0 auto; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>

    <?php if (session()->getFlashdata('error')) : ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?= form_open('/login/attempt') ?>

    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required autofocus>
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div>
        <button type="submit">Login</button>
    </div>

    <?= form_close() ?>
</div>
</body>
</html>
