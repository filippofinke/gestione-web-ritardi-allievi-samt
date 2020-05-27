/**
 * Funzione eseguita quando viene inviato il form di recupero password.
 */
$("#forgot-password").on("submit", (e) => {
  e.preventDefault();

  let email = $("#email").val();

  $("#btn-forgot-password")
    .prop("disabled", true)
    .html('<div class="spinner-border"></div>');

  // Invio una richiesta post con l'email alla quale inviare il recupero password.
  $.post("forgot-password", {
    email,
  })
    .then((data) => {
      $("#success-message").show();
    })
    .then(() => {
      $("#btn-forgot-password")
        .prop("disabled", false)
        .html("Recupera la password");
    });
});
