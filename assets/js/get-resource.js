var pl = function (){
    
    var afterReq = (res) => {
        if(res.status){
            $("#done_img").show();
            $("#loading_img").hide();
            $("#status").html("Done");
        }else{
            $("#status").html("Error.");
        }
    }

    var getAjax = function(){
        setTimeout( function(){
            // $.ajax({
            //     url: "/api/get-resource.php",
            //     dataType: 'JSON',
            //     type: 'GET'
            // }).done( (res) => {
            //     afterReq(res);
            // })
            afterReq({status : true});
        }, 1500)
  
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
  