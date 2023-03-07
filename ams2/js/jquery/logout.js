const $ = require('jquery');
$(function() {
  $("#logout").on("click", function(event) {
    event.preventDefault();
    $.ajax({
      url: "/php/logout.php",
      method: "POST",
      success: function(data) {
        console.log(data);
        window.location.href = "login.php";
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus + ": " + errorThrown);
      }
    });
  });
});