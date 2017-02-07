
// -----------------------------------------
//
//    Unique and valid email
//
// -----------------------------------------

function isUnique(email) {
  var invalid = false;
  $.post("uniquenessHandler.php", 
    {email:email}, 
    function(data) {
      if(data != "") { // If new email is NOT unique...
        $('#validateEmail').text((data));
        $("#submit").bind('click');
        $("#submit").click(function(event) {
          event.preventDefault();
        });        
      } else if(data=="") { // If new email is unique, let's check if it is valid.
        $("#validateEmail").text("");
        var email = $("#InputEmail").val();
        if (validateEmail(email)) {
          $("#validateEmail").text(email + " is valid :)");
          $("#validateEmail").css("color", "green");
          $("#InputEmail").removeClass("alert-danger");
          $("#InputEmail").addClass("alert-success");
          $("#submit").unbind('click');         
        } else {
          $("#validateEmail").text(email + " is not valid :(");
          $("#validateEmail").css("color", "red");
          $("#InputEmail").removeClass("alert-success");
          $("#InputEmail").addClass("alert-danger");
          $("#submit").bind('click');
          $("#submit").click(function(event) {
            event.preventDefault();
          });                   
        }
        return false;
      }    
  });
}

// -----------------------------------------
//
//    Validate Email
//
// -----------------------------------------

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

// -----------------------------------------
//
//    Password confirmation
//
// -----------------------------------------

$("#ConfirmPassword,#InputPassword").blur(function() {
  if($("#InputPassword").val() != $("#ConfirmPassword").val()) { 
    $("#validatePassword").text("Passwords do not match! :(");
    $("#validatePassword").css("color", "red");    
    $("#InputPassword").removeClass("alert-success");
    $("#InputPassword").addClass("alert-danger");
    $("#ConfirmPassword").removeClass("alert-success");
    $("#ConfirmPassword").addClass("alert-danger");
    $("#submit").bind('click'); 
    $("#submit").click(function(event) {
      event.preventDefault();
    });
  } else {
    $("#validatePassword").text("Passwords matches :)");
    $("#validatePassword").css("color", "green");
    $("#InputPassword").removeClass("alert-danger");
    $("#InputPassword").addClass("alert-success");     
    $("#ConfirmPassword").removeClass("alert-danger");
    $("#ConfirmPassword").addClass("alert-success");
    $("#submit").unbind('click');
  }
});
