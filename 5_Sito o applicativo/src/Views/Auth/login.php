<!DOCTYPE html>
<html>

<head>

  <?php require __DIR__ . '/../Global/head.php'; ?>
  <style>
    .bg-login-image {
      background: url(<?php echo BASE; ?>assets/img/login.jpg);
      background-position: center;
      background-size: cover
    }
  </style>
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <?php if ($token === null) : ?>
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Esegui l'accesso</h1>
                    </div>
                    <form id="login-form" class="user">
                      <div class="form-group">
                        <input name="email" type="email" class="form-control form-control-user" placeholder="Indirizzo email" <?php echo (isset($_SESSION["login_email"]) ? 'value="' . $_SESSION["login_email"] . '"' : '');
                                                                                                                              unset($_SESSION["login_email"]); ?> required>
                      </div>
                      <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user" placeholder="Password" required>
                      </div>
                      <button id="login-btn" class="btn btn-primary btn-user btn-block">
                        Accedi
                      </button>
                      <br>
                      <div id="error-login" class="alert alert-danger" style="display: none;"></div>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="forgot-password">Password dimenticata?</a>
                    </div>
                  </div>
                <?php else : ?>
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Cambia password</h1>
                    </div>
                    <form id="change-password-form" class="user">
                      <div class="form-group">
                        <input id="token" type="hidden" class="form-control form-control-user" value="<?php echo htmlspecialchars($token); ?>" required>
                      </div>
                      <div class="form-group">
                        <input id="password" type="password" class="form-control form-control-user" placeholder="Password" minlength="6" maxlength="32" required>
                      </div>
                      <div class="form-group">
                        <input id="repassword" type="password" class="form-control form-control-user" minlength="6" maxlength="32" placeholder="Riscrivi la password" required>
                      </div>
                      <button id="change-password-btn" class="btn btn-primary btn-user btn-block">
                        Cambia la password
                      </button>
                      <br>
                      <div id="error-change-password" class="alert alert-danger" style="display: none;"></div>
                      <div id="success-change-password" class="alert alert-success" style="display: none;"></div>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="login">Accedi!</a>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require __DIR__ . '/../Global/scripts.php'; ?>

  <?php if ($token === null) : ?>
    <script src="assets/js/pages/login.js"></script>
  <?php else : ?>
    <script src="assets/js/pages/change-password.js"></script>
  <?php endif; ?>

</body>

</html>