$(document).ready(function () {
  let sections = $("#sections-table").DataTable({
    lengthMenu: [
      [5, 10, 15],
      [5, 10, 15],
    ],
  });
  sections.on("draw", function () {
    let body = sections.table().body();
    $(body).unhighlight();
    $(body).highlight(sections.search());
  });

  $("#sections-table tbody").on("click", "button", function () {
    if (confirm("Sei sicuro di volere eliminare questa sezione?")) {
      let row = $(this).parents("tr")[0];
      $.ajax({
        url: "section/" + row.id,
        type: "DELETE",
      })
        .then(() => {
          sections.row(row).remove().draw();
        })
        .catch(() => {
          alert(
            "Impossibile eliminare la sezione, essa è collegata ad uno o più studenti!"
          );
        });
    }
  });

  $("#new-section-form").on("submit", function (event) {
    event.preventDefault();
    $.post("section", $("#new-section-form").serialize())
      .then((data) => {
        $("#sections-modal").modal("toggle");
        $("#section-error-message").hide();
        let name = $('input[name ="name"]').val();
        let node = sections.row
          .add([name, '<button class="btn btn-danger">Elimina</button>'])
          .node();
        node.id = name;
        node.lastChild.classList = "text-center";
        sections.draw(false);
        $('input[name ="name"]').removeClass("is-invalid");
        $("#new-section-form").trigger("reset");
      })
      .catch((err) => {
        if (err.status == 500) {
          $('input[name ="name"]').addClass("is-invalid");
          $("#section-error-message").show().text(err.responseText);
        }
      });
  });

  let years = $("#years-table").DataTable({
    lengthMenu: [
      [5, 10, 15],
      [5, 10, 15],
    ],
  });

  years.on("draw", function () {
    let body = years.table().body();
    $(body).unhighlight();
    $(body).highlight(years.search());
  });

  $("#new-year-form").on("submit", function (event) {
    event.preventDefault();
    let start_first_semester = $('input[name ="start_first_semester"]').val();
    let end_first_semester = $('input[name ="end_first_semester"]').val();
    let start_second_semester = $('input[name ="start_second_semester"]').val();
    let end_second_semester = $('input[name ="end_second_semester"]').val();

    let start_first_date = new Date(start_first_semester).getTime();
    let end_first_date = new Date(end_first_semester).getTime();
    let start_second_date = new Date(start_second_semester).getTime();
    let end_second_date = new Date(end_second_semester).getTime();

    if (
      start_first_date < end_first_date &&
      start_second_date > end_first_date &&
      start_second_date < end_second_date
    ) {
      $.post("year", $("#new-year-form").serialize())
        .then((data) => {
          $("#years-modal").modal("toggle");
          $("#year-error-message").hide();
          let node = years.row
            .add([
              formatDate(start_first_date) + " - " + formatDate(end_first_date),
              formatDate(start_second_date) +
                " - " +
                formatDate(end_second_date),
              '<button class="btn btn-danger">Elimina</button>',
            ])
            .node();
          node.id = data;
          node.lastChild.classList = "text-center";
          years.draw(false);

          $("#new-year-form").trigger("reset");
        })
        .catch((err) => {
          if (err.status == 500) {
            $("#year-error-message").show().text(err.responseText);
          }
        });
    } else {
      $("#year-error-message").text("Ricontrolla le date dei semestri.").show();
    }
  });

  $("#years-table tbody").on("click", "button", function () {
    if (confirm("Sei sicuro di volere eliminare questo anno scolastico?")) {
      let row = $(this).parents("tr")[0];
      years.row(row).remove().draw();
      $.ajax({
        url: "year/" + row.id,
        type: "DELETE",
      });
    }
  });

  const createTable = () => {
    let table = $("#settings-table").DataTable({
      columnDefs: [
        {
          targets: 2,
          searchable: false,
          orderable: false,
        },
      ],
      paging: false,
    });
    let body = $(table.table().body());
    table.on("draw", function () {
      body.unhighlight();
      body.highlight(table.search());
    });
    return table;
  };

  let table = createTable();

  $("#settings-table .edit-button").on("click", function (event) {
    $(table.table().body()).unhighlight();
    let button = $(event.target);
    let valueElement = event.target.parentElement.previousElementSibling;

    if (button.hasClass("edit-button")) {
      let value = valueElement.innerHTML;
      valueElement.innerHTML = "";
      let type = $(valueElement).data("type");

      let input = document.createElement("input");
      input.type = type;
      input.value = value;
      input.className = "form-control";
      valueElement.append(input);

      button.text("Salva");
      button.removeClass("edit-button");
    } else {
      let setting = valueElement.previousElementSibling.innerHTML;
      let value = valueElement.firstChild.value;

      $.post("setting/" + setting, {
        value,
      })
        .then((data) => {
          valueElement.innerHTML = value;

          table.destroy();
          table = createTable();

          button.text("Modifica");
          button.addClass("edit-button");
        })
        .catch((error) => {
          $(valueElement.firstChild).addClass("is-invalid");
        });
    }
  });
});
