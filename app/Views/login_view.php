<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viyona Fintech | Login</title>
    <link rel="icon" type="image/png" href="<?= base_url('public/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="login-container fade-in">
      <div class="login-wrapper">
        <div class="login-title"><span>Spot the Phish contest</span></div>
        <form method="post" action="<?= base_url('login') ?>" class="login-form">
          
          <?php if(session()->getFlashdata('error')): ?>
            <div style="color:var(--accent-error); text-align:center; margin-bottom:20px; font-weight:500;">
                <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif; ?>

          <div class="input-row">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <i class="fas fa-user"></i>
          </div>
          <div class="input-row">
            <input type="email" name="email" placeholder="Office Email" required>
            <i class="fas fa-envelope"></i>
          </div>
          
          <div class="row button" style="margin-top: 30px;">
            <input type="submit" value="Login">
          </div>
        </form>
      </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let screen_size = window.innerWidth;
            let form = document.querySelector('form');
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'screen_size';
            input.value = screen_size;
            form.appendChild(input);

            // Auto-redirect to admin login
            let nameInput = document.querySelector('input[name="full_name"]');
            if (nameInput) {
                nameInput.addEventListener('input', function(e) {
                    if (e.target.value.trim().toLowerCase() === 'admin') {
                        window.location.href = '<?= base_url('admin_login') ?>';
                    }
                });
            }
        });
    </script>
</body>
</html>