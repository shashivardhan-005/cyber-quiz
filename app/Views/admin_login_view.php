<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viyona Fintech | Admin Login</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="login-container fade-in">
      <div class="login-wrapper">
        <div class="login-title"><span>Admin Portal</span></div>
        <form method="post" action="<?= base_url('admin_attempt') ?>" class="login-form">
          
          <?php if(session()->getFlashdata('error')): ?>
            <div style="color:var(--accent-error); text-align:center; margin-bottom:20px; font-weight:500;">
                <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <div class="input-row">
            <input type="text" name="username" placeholder="Username" required>
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="input-row">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock"></i>
          </div>
          
          <div class="row button" style="margin-top: 30px;">
            <input type="submit" value="Login">
          </div>
          <div style="text-align:center; margin-top:20px;">
              <a href="<?= base_url('/') ?>" style="text-decoration:none; color:var(--text-light); font-size:0.9rem;">Back to User Login</a>
          </div>
        </form>
      </div>
    </div>
</body>
</html>