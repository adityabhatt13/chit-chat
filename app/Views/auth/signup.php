<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <title>Signup</title>
</head>
<body>
<div class="app-title">CHIT CHAT</div>
    <div class="card">
        <h2>Create an Account</h2>
        <?php if(isset($validation)): ?>
            <div class="msg error"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/auth/signup">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        
        <div class="link">
            <a href="/auth/login">Already have an account? Log in</a>
        </div>
    </div>
</body>
</html>
