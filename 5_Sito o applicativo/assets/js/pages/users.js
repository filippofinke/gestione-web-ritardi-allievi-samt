const createTable = () => {
  var table = $("#users-table").DataTable({
    columnDefs: [
      {
        targets: [3, 4],
        searchable: false,
        orderable: false,
      },
    ],
    lengthMenu: [
      [5, 10, 15],
      [5, 10, 15],
    ],
  });

  table.on("draw", function () {
    var body = $(table.table().body());

    body.unhighlight();
    body.highlight(table.search());
  });
  return table;
};

$(document).ready(function () {
  var table = createTable();

  $("#users-table tbody").on("click", "button", function () {
    if (confirm("Sei sicuro di volere eliminare questo utente?")) {
      let row = $(this).parents("tr")[0];
      $.ajax({
        url: "user/" + row.id,
        type: "DELETE",
        success: function () {
          table.row(row).remove().draw();
        },
      });
    }
  });

  $("#users-table tbody").on("click", 'input[type="checkbox"]', function () {
    let row = $(this).parents("tr")[0];
    let checkboxes = $(row).find('input[type="checkbox"]');
    let permission = 0;
    for (let i = 0; i < checkboxes.length; i++) {
      if (this.value == 8 && this.checked) checkboxes[i].checked = true;
      if (checkboxes[i].checked) {
        permission = permission | Number(checkboxes[i].value);
      }
    }
    $.post("user/" + row.id, { permission });
  });

  $("#new-user-form").on("submit", function (event) {
    event.preventDefault();
    $.post("user", $("#new-user-form").serialize())
      .then(() => {
        $("#users-modal").modal("toggle");
        $("#error-message").hide();
        let name = $('input[name ="name"]').val();
        let lastname = $('input[name ="lastname"]').val();
        let email = $('input[name ="email"]').val();
        let node = table.row
          .add([
            name,
            lastname,
            email,
            '<div class="row"><div class="col-sm"><div class="form-check"><input class="form-check-input" type="checkbox" value="1" checked><label class="form-check-label">Inserimento ritardi</label></div></div><div class="col-sm"><div class="form-check"><input class="form-check-input" type="checkbox" value="2" checked><label class="form-check-label">Visione ritardi</label></div></div></div><div class="row"><div class="col-sm"><div class="form-check"><input class="form-check-input" type="checkbox" value="4" checked><label class="form-check-label">Creazione PDF</label></div></div><div class="col-sm"><div class="form-check"><input class="form-check-input" type="checkbox" value="8"><label class="form-check-label">Amministratore</label></div></div></div>',
            '<button class="btn btn-danger">Elimina</button>',
          ])
          .node();
        node.id = email;
        node.lastChild.classList = "text-center";
        table.draw(false);
        $("#new-user-form").trigger("reset");
      })
      .catch((err) => {
        if (err.status == 500) {
          $("#error-message").text(err.responseText).show();
        }
      });
  });
});
