$(document).ready(function(){
    $('#addcomment').submit(function() {
      msg = $('.input').val(); // get the message
      if (msg.length > 100) // make sure character are within the limit, this is optional
      {
        alert("Characters must be only 100");
      }else if (msg == ""){
        alert("Please enter a message");
      }else{
        $('input[type=submit]').attr('disabled', true); // to prevent multiple insert at once
        $.ajax({
          type: "POST",
          url: "/insertcomment.php",
          data: "msg=" + msg,
          cache: false,
          success: function(html){
            $('#listdiv').append(html);
            $('#listdiv .list:last').hide().slideDown('slow'); // for effects only
            $('.input').val("");// reset the textarea value
             $('input[type=submit]').attr('disabled', false);
          }
        });
      }
      return false;
    });
  });
