/**
 * Funzione eseguita quando viene inviato il form di accesso.
 */
$("#login-form").on("submit", (e) => {
  e.preventDefault();

  let params = $("#login-form").serialize();

  $("#login-btn")
    .prop("disabled", true)
    .html('<div class="spinner-border"></div>');
  
  // Eseguo una richiesta post a login con i paramteri del form.
  $.post("login", params)
    .then(() => {
      location.href = "";
    })
    .catch((err) => {
      $("#error-login").text("Credenziali errate!").show();
    })
    .then(() => {
      $("#login-btn").prop("disabled", false).html("Accedi");
    });
});
