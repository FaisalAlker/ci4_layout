<?= $this->extend('layout/main') ?> 

<?= $this->section('content') ?>
    <div>Profile</div>
    <div>Email: <?= session()->get('email'); ?></div>
    <div>User Data: <?= var_dump($user)?></div>
<?= form_open_multipart('/admin/upload_avatar') ?>
    <div>
        <?php if (!empty($user['avatar'])): ?>
            <p><strong>Current Avatar:</strong></p>
            <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Avatar" width="120" style="border-radius: 50px;">
        <?php else: ?>
            <p>No avatar uploaded yet.</p>
        <?php endif; ?>

    </div>
    <p>
        <?= form_label('Avatar', 'avatar') ?><br>
        <?= form_upload('avatar') ?>
    </p>

    <p><?= form_submit('submit', 'Upload') ?></p>
    <?= form_close() ?>

    <!-- Tampilkan pesan sukses/gagal -->
    <?php if (session()->getFlashdata('message')): ?>
        <p style="color: green"><?= session()->getFlashdata('message') ?></p>
    <?php endif; ?>
<?= $this->endSection() ?>
