var pl_topbot = function (){

  var afterReq = function( res ){

    var barChartData = {
      labels: temp_name,
      datasets: res
    };

    var config = {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: false,
          text: 'Top & Bot Klasemen'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          callbacks: {
            footer : function(a, b){
              let txt = "";
              let txtTop = "";
              let txtBot = "";
              if(res[0].gw[a[0].index].length > 0){
                txtTop += "GW Top: " + res[0].gw[a[0].index].join(", ");
              }

              if(res[1].gw[a[1].index].length > 0){
                txtBot += "GW Bot: " + res[1].gw[a[1].index].join(", ");
              }

              if(txtTop != "" && txtBot != ""){
                txt = txtTop + "  |  " + txtBot;
              }else {
                if(txtTop != ""){
                  txt = txtTop;
                }else{
                  txt = txtBot;
                }
              }

              return txt;
            }
          }
        },
        responsive: true
      }
    };

    var ctx = document.getElementById('canvas_topbot').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });


  }

  var getAjax = function(){

    $.ajax({
      url: "/api/top-bot-weekly.php",
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
  pl_topbot.init();
})
