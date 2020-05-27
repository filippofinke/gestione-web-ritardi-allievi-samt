<!DOCTYPE html>
<html>

<head>

  <?php require __DIR__ . '/../Global/head.php'; ?>
  <style>
    .bg-password-image {
      background: url(<?php echo BASE; ?>assets/img/forgot-password.jpg);
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
              <div class="col-lg-6 d-none d-lg-block bg-password-image">
                <a class="position-absolute ml-1" style="bottom: 0px;" href="https://www.freepik.com/free-vector/forgot-password-concept-illustration_7070629.htm">Di @stories</a>
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Password dimenticata?</h1>
                    <p class="mb-4">Inserisci il tuo indirizzo email per recuperare la password!</p>
                  </div>
                  <form id="forgot-password" class="user">
                    <div class="form-group">
                      <input id="email" type="email" class="form-control form-control-user" placeholder="Indirizzo email" required>
                    </div>
                    <div id="success-message" class="alert alert-success" style="display: none;">
                      Email di recupero inviata con successo!
                    </div>
                    <button id="btn-forgot-password" class="btn btn-primary btn-user btn-block">
                      Recupera la password
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login">Accedi!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require __DIR__ . '/../Global/scripts.php'; ?>

  <script src="assets/js/pages/forgot-password.js"></script>

</body>

</html>