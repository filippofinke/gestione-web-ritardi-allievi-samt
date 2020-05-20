$("#forgot-password").on("submit", (e) => {
  e.preventDefault();

  let email = $("#email").val();

  $("#btn-forgot-password")
    .prop("disabled", true)
    .html('<div class="spinner-border"></div>');
  $.post("forgot-password", {
    email,
  })
    .then((data) => {
      $("#error-message").hide();
      $("#success-message")
        .text("Email di recupero inviata con successo!")
        .show();
    })
    .catch((err) => {
      $("#success-message").hide();
      if (err.status == 400) {
        $("#error-message").text("Inserisci una email valida!").show();
      } else {
        $("#error-message")
          .text("Impossibile collegarsi al server e-mail, riprova più tardi!")
          .show();
      }
    })
    .then(() => {
      $("#btn-forgot-password")
        .prop("disabled", false)
        .html("Recupera la password");
    });
});
