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
      $("#success-message").show();
    })
    .then(() => {
      $("#btn-forgot-password")
        .prop("disabled", false)
        .html("Recupera la password");
    });

  $("#success-message").show();
});
