$("#login-form").on("submit", (e) => {
  e.preventDefault();

  let params = $("#login-form").serialize();

  $("#login-btn")
    .prop("disabled", true)
    .html('<div class="spinner-border"></div>');
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
