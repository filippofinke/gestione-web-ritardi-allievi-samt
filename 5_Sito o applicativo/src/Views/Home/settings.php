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
                        <h1 class="h3 mb-0 text-gray-800">Impostazioni</h1>
                    </div>

                    <div class="row">
                        <div class="card shadow mb-4 p-0 col-lg-6">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary d-inline">Sezioni</h6>
                                <a data-toggle="modal" data-target="#sections-modal" class="float-right btn btn-sm btn-primary shadow-sm text-white">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Aggiungi una sezione
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="sections-table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sections as $section) : ?>
                                                <tr id="<?php echo $section['name']; ?>">
                                                    <td><?php echo $section["name"]; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger">Elimina</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4 p-0 col-lg-6">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary d-inline">Anni scolastici</h6>
                                <a data-toggle="modal" data-target="#years-modal" class="float-right btn btn-sm btn-primary shadow-sm text-white">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Aggiungi un anno scolastico
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="years-table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Primo semestre</th>
                                                <th>Secondo semestre</th>
                                                <th>Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($years as $year) :
                                                foreach ($year as $key => $value) {
                                                    if ($key == "id") continue;
                                                    $temp = explode("-", $value);
                                                    $year[$key] = $temp[2] . "." . $temp[1] . "." . $temp[0];
                                                }
                                            ?>
                                                <tr id="<?php echo $year['id']; ?>">
                                                    <td><?php echo $year["start_first_semester"]; ?> - <?php echo $year["end_first_semester"]; ?></td>
                                                    <td><?php echo $year["start_second_semester"]; ?> - <?php echo $year["end_second_semester"]; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger">Elimina</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Settings table -->
                        <div class="card shadow mb-4 p-0 col">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Configurazione</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="settings-table" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Impostazione</th>
                                                <th>Valore</th>
                                                <th>Azione</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($settings as $setting) : ?>
                                                <tr id="<?php echo $setting['name']; ?>">
                                                    <td><?php echo $setting["name"]; ?></td>
                                                    <td data-type="<?php echo $setting["type"]; ?>"><?php echo $setting["value"]; ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-primary edit-button">
                                                            Modifica
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

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="sections-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi una sezione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new-section-form">
                        <div class="input-group custom mt-2">
                            <input pattern="[A-Za-z0-9 ]{1,10}" name="name" type="text" class="form-control" placeholder="Nome della sezione" minlength="1" maxlength="10" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fa fa-pen"></i></span>
                            </div>
                        </div>
                        <div id="section-error-message" class="alert alert-danger mt-2" style="display: none;"></div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary btn-block">Crea</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="years-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi un anno scolastico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new-year-form">
                        <h6>Primo semestre</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input name="start_first_semester" type="date" class="form-control" placeholder="Inizio">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input name="end_first_semester" type="date" class="form-control" placeholder="Fine">
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1">Secondo semestre</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input name="start_second_semester" type="date" class="form-control" placeholder="Inizio">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group custom">
                                    <input name="end_second_semester" type="date" class="form-control" placeholder="Fine">
                                </div>
                            </div>
                        </div>
                        <div id="year-error-message" class="alert alert-danger mt-2" style="display: none;"></div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary btn-block">Crea</button>
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
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/pages/settings.js"></script>

</body>

</html>