<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'No title' ?></title>
</head>
<body>
    <h2>Register</h2>

    <?= form_open('register') ?>
    <div>
        <?= form_input([
            'name' => 'email',
            'value' => old('email'),
            'placeholder' => 'Email',
            'class' => 'form-control',
            'style' => 'border: 1px solid #ccc; padding: 10px;'
        ]) ?>
    </div>
    <?php if (isset($validation)) : ?>
        <div>
            <?= validation_show_error('email') ?>
        </div>
    <?php endif; ?>
    <div><?= form_password('password', '', ['placeholder' => 'Password']) ?></div>
     <?php if (isset($validation)) : ?>
        <div>
            <?= validation_show_error('password') ?>
        </div>
    <?php endif; ?>
    <div><?= form_password('pass_confirm', '', ['placeholder' => 'Konfirmasi Password']) ?></div>
     <?php if (isset($validation)) : ?>
        <div>
            <?= validation_show_error('pass_confirm') ?>
        </div>
    <?php endif; ?>
    <div><?= form_submit('submit', 'Register') ?></div>
    <?= form_close() ?>


</body>
</html>
