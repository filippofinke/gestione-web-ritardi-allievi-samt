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
                        <h1 class="h3 mb-0 text-gray-800">Recuperi</h1>
                    </div>

                    <!-- Users table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary d-inline">Studenti</h6>
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
                                            <tr id="<?php echo $student['email']; ?>">
                                                <td><?php echo $student["name"]; ?></td>
                                                <td><?php echo $student["last_name"]; ?></td>
                                                <td><?php echo $student["section"]; ?></td>
                                                <td><?php echo $student["email"]; ?></td>
                                                <td><?php echo count($student["delays"]); ?></td>
                                                <td><?php echo count($student["to_recover"]); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary view-button" <?php echo (Permission::canSelect()) ? "" : "disabled"; ?>>Visualizza</button>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="view-student-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Osservazioni</th>
                                    <th>Recuperato</th>
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
                "order": [
                    [0, "asc"]
                ],
                "columnDefs": [{
                    "targets": [3],
                    "searchable": false,
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

            $('#view-student-table tbody').on('click', 'button', function(e) {

                let row = $(this).parents('tr')[0];
                let elements = row.getElementsByTagName("td");
                let recovered = elements[2];
                if (this.innerText == "Recuperato") {
                    recovered.innerHTML = '<input type="date" class="form-control">';
                    this.innerText = "Salva";
                } else {
                    let date = recovered.firstChild.value;
                    if (!isNaN(new Date(date))) {
                        recovered.innerText = formatDate(date);
                        this.innerText = "Recuperato";
                        this.disabled = true;

                        $.post("delay/" + row.id, {
                            date
                        });

                        let to_recover = currentRow.getElementsByTagName("td")[5];
                        to_recover.innerText = Number(to_recover.innerText) - 1;
                    } else {
                        recovered.firstChild.classList = "form-control is-invalid";
                    }
                }
            });

            $('#students-table tbody').on('click', '.view-button', async function() {
                currentRow = $(this).parents('tr')[0];
                let student_email = $(this).parents('tr')[0].id;
                let delays = await fetch('student/' + student_email + '/recoveries').then(r => r.json());
                $("#view-student-email").text(student_email);
                delays_table.clear();
                for (let delay of delays) {
                    let node = delays_table.row.add([
                        delay.date,
                        delay.observations,
                        (delay.recovered) ? delay.recovered : "No",
                        '<button class="btn btn-primary" ' + ((delay.recovered || <?php echo (!Permission::canInsert()) ? "true" : "false"; ?>) ? 'disabled' : '') + '>Recuperato</button>'
                    ]).node();
                    node.lastChild.classList = "text-center";
                    node.id = delay.id;
                }
                delays_table.draw();
                $("#view-student-modal").modal('show');
            });

        });
    </script>

</body>

</html>