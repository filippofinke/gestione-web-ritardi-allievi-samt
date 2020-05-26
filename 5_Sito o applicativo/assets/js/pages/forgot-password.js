$("#forgot-password").on("submit", (e) => {
  e.preventDefault();

  let email = $("#email").val();

  $.post("forgot-password", {
    email,
  });

  $("#success-message").show();
});
