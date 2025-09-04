<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <title>Login</title>
</head>
<body>
    <div class="app-title">CHIT CHAT</div>
    <div class="card">
        <h2>Login</h2>
        <?php if(isset($error)): ?>
            <p class="msg error"><?= $error ?></p>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <p class="msg success"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>
        <?php if(isset($validation)): ?>
            <div class="error"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/auth/login">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div class="link">
            <a href="/auth/signup">Don't have an account? Signup</a>
        </div>
    </div>
</body>
</html>
