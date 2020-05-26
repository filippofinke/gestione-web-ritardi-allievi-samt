<?php

use FilippoFinke\Libs\Permission;

?>
<!DOCTYPE html>
<html>

<head>

    <?php require __DIR__ . '/../Global/head.php'; ?>
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="assets/css/dataTables.searchHighlight.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require __DIR__ . '/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require __DIR__ . '/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Gestione utenti</h1>
                    </div>

                    <!-- Users table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-inline">Utenti</h6>
                            <a data-toggle="modal" data-target="#users-modal" class="float-right btn btn-sm btn-primary shadow-sm text-white">
                                <i class="fas fa-user-plus fa-sm text-white-50"></i> Aggiungi un utente
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>E-mail</th>
                                            <th>Permessi</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <tr id="<?php echo $user['email']; ?>">
                                                <td><?php echo $user["name"]; ?></td>
                                                <td><?php echo $user["last_name"]; ?></td>
                                                <td><?php echo $user["email"]; ?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="form-check">
                                                                <input <?php echo (Permission::canInsert($user["permission"])) ? 'checked' : ''; ?> class="form-check-input" type="checkbox" value="1" <?php echo ($user["email"] == $_SESSION["email"]) ? "disabled" : ""; ?>>
                                                                <label class="form-check-label">
                                                                    Inserimento ritardi
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="form-check">
                                                                <input <?php echo (Permission::canSelect($user["permission"])) ? 'checked' : ''; ?> class="form-check-input" type="checkbox" value="2" <?php echo ($user["email"] == $_SESSION["email"]) ? "disabled" : ""; ?>>
                                                                <label class="form-check-label">
                                                                    Visione ritardi
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm">
                                                            <div class="form-check">
                                                                <input <?php echo (Permission::canCreate($user["permission"])) ? 'checked' : ''; ?> class="form-check-input" type="checkbox" value="4" <?php echo ($user["email"] == $_SESSION["email"]) ? "disabled" : ""; ?>>
                                                                <label class="form-check-label">
                                                                    Creazione PDF
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div class="form-check">
                                                                <input <?php echo (Permission::isAdmin($user["permission"])) ? 'checked' : ''; ?> class="form-check-input" type="checkbox" value="8" <?php echo ($user["email"] == $_SESSION["email"]) ? "disabled" : ""; ?>>
                                                                <label class="form-check-label">
                                                                    Amministratore
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger" <?php echo ($user["email"] == $_SESSION["email"]) ? "disabled" : ""; ?>>
                                                        Elimina
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require __DIR__ . '/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="users-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi un utente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new-user-form">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input style="text-transform: capitalize;" pattern="[A-Za-zÀ-ÖØ-öø-ÿ ]{1,20}" name="name" type="text" class="form-control" placeholder="Nome" required maxlength="20" minlength="1">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input style="text-transform: capitalize;" pattern="[A-Za-zÀ-ÖØ-öø-ÿ ]{1,20}" name="lastname" type="text" class="form-control" placeholder="Cognome" required maxlength="20" minlength="1">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group custom mt-2">
                            <input name="email" type="email" class="form-control" placeholder="Indirizzo email" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                        </div>
                        <div id="error-message" class="alert alert-danger mt-2" style="display: none;"></div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <button id="new-user-button" type="submit" class="btn btn-primary btn-block">Crea</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../Global/scripts.php'; ?>

    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.highlight.js"></script>
    <script src="assets/js/dataTables.searchHighlight.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/pages/users.js"></script>

</body>

</html>