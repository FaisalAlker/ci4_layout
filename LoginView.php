<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'No title' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .full-height-center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container full-height-center">
        <h2>Login</h2>

        <?= form_open('/login/submit') ?>

        <div>
            <?= form_label('Email', 'email') ?><br>
            <?= form_input('email', set_value('email')) ?>
        </div>
        <div class="text-danger">
            <?= validation_show_error('email') ?>
        </div>
        
        <div>
            <?= form_label('Password', 'password') ?><br>
            <?= form_password('password') ?>
        </div>
        <div class="text-danger">
            <?= validation_show_error('password') ?>    
        </div>
        
        <p>
            <?= form_submit('submit', 'Login', ['class' => 'btn btn-success w-100']) ?>
        </p>
        
        <?= form_close() ?>

        <?php if (isset($loginError)): ?>
            <div style="color: red;"><?= $loginError ?></div>
        <?php endif; ?>
    </div>
    
</body>
</html>
