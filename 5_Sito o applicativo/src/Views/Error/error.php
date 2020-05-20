<!DOCTYPE html>
<html>

<head>

  <?php require __DIR__ . '/../Global/head.php'; ?>

</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block" style="background: url(/assets/img/error.jpg); background-size: cover; background-position: center center;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><?php echo $title; ?></h1>
                  </div>
                  <div class="alert alert-danger" role="alert">
                    <?php echo $message; ?>
                  </div>
                  <div class="text-center">
                    <a href="" class="btn btn-primary btn-icon-split">
                      <span class="icon text-white-50">
                        <i class="fas fa-home"></i>
                      </span>
                      <span class="text">Torna alla pagina principale</span>
                    </a>
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

</body>

</html>