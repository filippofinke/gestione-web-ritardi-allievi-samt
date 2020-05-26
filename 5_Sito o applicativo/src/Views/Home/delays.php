<!DOCTYPE html>
<html>

<head>

    <?php

    use FilippoFinke\Libs\Permission;
    use FilippoFinke\Models\Settings;

    require __DIR__ . '/../Global/head.php'; ?>
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
                        <h1 class="h3 mb-0 text-gray-800">Ritardi <?php echo ($selectedYear) ? date("Y", strtotime($selectedYear["start_first_semester"])) . "/" . date("Y", strtotime($selectedYear["end_second_semester"])) : " - Anno scolastico non valido."; ?></h1>
                    </div>

                    <!-- Users table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-inline">Studenti</h6>
                            <button data-toggle="modal" data-target="#students-modal" class="float-right btn btn-sm btn-primary shadow-sm text-white" <?php echo (Permission::canInsert() && $canInteract) ? "" : "disabled"; ?>>
                                <i class="fas fa-user-plus fa-sm text-white-50"></i> Aggiungi uno studente
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="students-table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>Sezione</th>
                                            <th>E-mail</th>
                                            <th>Ritardi</th>
                                            <th>Da recuperare</th>
                                            <th>Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student) : ?>
                                            <tr id="<?php echo $student['id']; ?>">
                                                <td><?php echo $student["name"]; ?></td>
                                                <td><?php echo $student["last_name"]; ?></td>
                                                <td><?php echo $student["section"]; ?></td>
                                                <td><?php echo $student["email"]; ?></td>
                                                <td><?php echo count($student["delays"]); ?></td>
                                                <td><?php echo count($student["to_recover"]); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary view-button mt-1" <?php echo (Permission::canSelect()) ? "" : "disabled"; ?>>Visualizza</button>
                                                    <button class="btn btn-primary new-delay-button mt-1" <?php echo (Permission::canInsert() && $canInteract) ? "" : "disabled"; ?>>Aggiungi ritardo</button>
                                                    <button class="btn btn-primary create-pdf mt-1" <?php echo (Permission::canCreate()) ? "" : "disabled"; ?>>Crea PDF</button>
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

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="students-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiungi uno studente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new-student-form">
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
                        <div class="input-group custom mt-2">
                            <select name="section" class="form-control" required>
                                <option value="" selected disabled>Seleziona una sezione</option>
                                <?php foreach ($sections as $section) : ?>
                                    <option><?php echo $section["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                            </div>
                        </div>
                        <div id="student-error-message" class="alert alert-danger mt-2" style="display: none;"></div>
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

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="view-student-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visualizzazione di <span id="view-student-email"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button data-toggle="modal" data-target="#delays-modal" class="float-right btn btn-sm btn-primary shadow-sm text-white mb-2" <?php echo (Permission::canInsert() && $canInteract) ? "" : "disabled"; ?>>
                        <i class="fas fa-gavel fa-sm text-white-50"></i> Aggiungi un ritardo
                    </button>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="view-student-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Osservazioni</th>
                                    <th>Recuperato</th>
                                    <th>Giustificato</th>
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated--fade-in" tabindex="-1" role="dialog" id="delays-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aggiunta ritardi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="ml-3 mr-3" id="new-delay-form">
                        <div class="form-group row">
                            <label for="date" class="col-form-label">Data del ritardo</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group row">
                            <label for="observations" class="col-form-label">Osservazioni</label>
                            <textarea class="form-control" id="observations" name="observations" minlength="0" maxlength="255"></textarea>
                        </div>
                        <div class="form-group row">
                            <select id="justified" name="justified" class="form-control" required>
                                <option value="0" selected>Ritardo conteggiato</option>
                                <option value="1">Ritardo giustificato</option>
                            </select>
                        </div>
                        <div id="delay-error-message" class="alert alert-danger mt-2" style="display: none;"></div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Inserisci</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdf-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Visualizza PDF</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div style="margin:0px;padding:0px;overflow:hidden">
                        <iframe id="iframe" frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="download-button" class="btn btn-primary text-white" download>Scarica</a>
                    <button type="button" class="btn btn-secondary" id="print-pdf">Stampa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
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
    <script>
        const max_delays = <?php echo Settings::getValue('max_delays'); ?>;

        $(document).ready(function() {

            let currentRow = null;

            var delays_table = $('#view-student-table').DataTable({
                "lengthMenu": [
                    [5, 10, 15],
                    [5, 10, 15]
                ],
                "aaSorting": [],
                "columnDefs": [{
                    "targets": [0, 4],
                    "orderable": false
                }]
            });

            delays_table.on('draw', function() {
                var body = $(delays_table.table().body());
                body.unhighlight();
                body.highlight(delays_table.search());
            });

            var table = $('#students-table').DataTable({
                "lengthMenu": [
                    [5, 10, 15],
                    [5, 10, 15]
                ],
                "columnDefs": [{
                    "targets": [6],
                    "searchable": false,
                    "orderable": false
                }]
            });

            table.on('draw', function() {
                var body = $(table.table().body());
                body.unhighlight();
                body.highlight(table.search());
            });

            $('#new-delay-form').on('submit', function(event) {
                event.preventDefault();
                let data = $('#new-delay-form').serialize();
                data += "&id=" + currentRow.id;

                $.post("delay", data).then((data) => {
                    $('#delays-modal').modal('toggle');
                    $('#delay-error-message').hide();
                    let date = $('input[name ="date"]').val();
                    let observations = $('textarea[name ="observations"]').val();
                    let justified = Number($('select[name ="justified"]').val());
                    let node = delays_table.row.add([
                        formatDate(date),
                        observations,
                        'No',
                        (justified) ? 'Si' : 'No',
                        '<button class="btn btn-danger">Elimina</button>'
                    ]).node();
                    node.id = data;
                    node.lastChild.classList = "text-center";
                    delays_table.draw();

                    let elements = currentRow.getElementsByTagName("td");
                    let delays = elements[4];
                    let to_recover = elements[5];
                    delays.innerText = Number(delays.innerText) + 1;

                    if (Number(delays.innerText) >= max_delays && justified == 0) {
                        to_recover.innerText = Number(to_recover.innerText) + 1;
                    }

                    $('#new-delay-form').trigger("reset");
                }).catch(err => {
                    if (err.status == 500) {
                        $('#delay-error-message').show().text(err.responseText);
                    }
                });
            });

            $('#students-table tbody').on('click', '.view-button', async function() {
                currentRow = $(this).parents('tr')[0];
                let student_id = currentRow.id;
                let delays = await fetch('student/' + student_id).then(r => r.json());
                let student_email = currentRow.getElementsByTagName("td")[3].innerText;
                $("#view-student-email").text(student_email);
                delays_table.clear();
                for (let delay of delays) {
                    let node = delays_table.row.add([
                        delay.date,
                        delay.observations,
                        (delay.recovered) ? delay.recovered : "No",
                        (Number(delay.justified)) ? "Si" : "No",
                        '<button class="btn btn-danger" <?php echo (Permission::canInsert() && $canInteract) ? "" : "disabled"; ?>>Elimina</button>'
                    ]).node();
                    node.lastChild.classList = "text-center";
                    node.id = delay.id;
                }
                delays_table.draw();
                $("#view-student-modal").modal('show');
            });

            $('#students-table tbody').on('click', '.new-delay-button', function() {
                currentRow = $(this).parents('tr')[0];
                $("#delays-modal").modal('show');
            });

            $('#students-table tbody').on('click', '.create-pdf', function() {
                let student_id = $(this).parents('tr')[0].id;
                var url = "student/" + student_id + "/pdf";
                $('#iframe').attr("src", url);
                $('#download-button').attr("href", url);
                $('#pdf-modal').modal('toggle');
            });

            $('#print-pdf').on('click', function() {
                $('#iframe').get(0).contentWindow.print();
            });

            $('#view-student-table tbody').on('click', 'button', function() {
                if (confirm("Sei sicuro di voler annullare il ritardo?")) {
                    let row = $(this).parents('tr')[0];

                    let elements = currentRow.getElementsByTagName("td");
                    let delays = elements[4];
                    let to_recover = elements[5];
                    delays.innerText = Number(delays.innerText) - 1;
                    if (Number(to_recover.innerText) > 0 && row.getElementsByTagName("td")["3"].innerText != "Si") {
                        to_recover.innerText = Number(to_recover.innerText) - 1;
                    }

                    delays_table.row(row).remove().draw(true);
                    $.ajax({
                        url: 'delay/' + row.id,
                        type: 'DELETE'
                    });
                }
            });

            $('#new-student-form').on('submit', function(event) {
                event.preventDefault();
                $.post("student", $('#new-student-form').serialize()).then((data) => {
                    $('#students-modal').modal('toggle');
                    $('#student-error-message').hide();
                    let name = $('input[name ="name"]').val();
                    let lastname = $('input[name ="lastname"]').val();
                    let email = $('input[name ="email"]').val();
                    let section = $('select[name ="section"]').val();
                    let node = table.row.add([
                        name,
                        lastname,
                        section,
                        email,
                        '0',
                        '0',
                        `<button class="btn btn-primary view-button mt-1" <?php echo (Permission::canSelect()) ? "" : "disabled"; ?>>Visualizza</button> <button class="btn btn-primary new-delay-button mt-1" <?php echo (Permission::canInsert()) ? "" : "disabled"; ?>>Aggiungi ritardo</button> <button class="btn btn-primary create-pdf mt-1" <?php echo (Permission::canCreate()) ? "" : "disabled"; ?>>Crea PDF</button>`
                    ]).node();
                    node.id = data;
                    node.lastChild.classList = "text-center";
                    table.draw(false);
                    $('#new-student-form').trigger("reset");
                }).catch(err => {
                    if (err.status == 500) {
                        $('#student-error-message').show().text(err.responseText);
                    }
                });
            });

        });
    </script>

</body>

</html>