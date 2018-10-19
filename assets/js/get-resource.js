var pl = function (){
    
    var afterReq = (res) => {
        if(res.status == "done"){
            $("#done_img").show();
            $("#loading_img").hide();
            $("#status").html("Done");
        }else{
            $("#status").html("Error.");
        }
    }

    var getAjax = function(){
        
        $.ajax({
            url: "/api/get-resource.php",
            dataType: 'JSON',
            type: 'GET'
        }).done( (res) => {
            afterReq(res);
        });
  
    }
  
    return{
      init: function() {
        getAjax();
      }
    }
  
  }();
  
  $(document).ready( () => {
    $("#status").html("Getting data...");
    $("#done_img").hide();
    pl.init();
  })
  