/**
 * Funzione eseguita quando viene inviato il form di cambio password.
 */
$("#change-password-form").on("submit", (e) => {
  e.preventDefault();
  let token = $("#token").val();
  let password = $("#password").val();
  let repassword = $("#repassword").val();
  // Controllo che le password siano uguali.
  if (password == repassword) {
    $("#change-password-btn").prop("disabled", true);

    // Invio richiesta post di cambio password.
    $.post("change-password", {
      token,
      password,
    })
      .then(() => {
        $("#success-change-password")
          .text("Password cambiata con successo!")
          .show();
        $("#error-change-password").hide();

        setTimeout(function () {
          location.href = "login";
        }, 1000);
      })
      .catch((err) => {
        $("#error-change-password")
          .text("Link di recupero password non valido!")
          .show();
      })
      .then(() => {
        $("#change-password-btn").prop("disabled", false);
      });
  } else {
    $("#error-change-password")
      .text("Le due password non corrispondono!")
      .show();
  }
});
