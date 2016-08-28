//Display form

$("#check_status").click(function() {

    $("#field_status").fadeIn("slow"); //Effect

});


//Hide form

$("#close_status").click(function() {

 $("#field_status").fadeOut('slow'); //Close the editing effect

});


//Processing data

$("#take_status").click(function() {

  $("#load").html("<img  src=\"pic/loading.gif\" border=\"0\" alt=\"Loading...\" />");    

  var status_text = $("#status_text").val(); //Status value

  var id_user = <?$CURUSER['id'];?> //User ID

   $.post('takestatus.php',{'type': 'status_text' , 'status_text':status_text, 'id_user':id_user},

           function(response) {

                $("#load").empty();

                $('#field_status').fadeOut('slow');

                $('#result_status').html(response);

            }, 'html');

});