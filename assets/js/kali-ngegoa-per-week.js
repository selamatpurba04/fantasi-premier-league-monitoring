var pl = function (){

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
          display: true,
          text: 'Pro & Noob Weekly'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          callbacks: {
            footer : function(a, b){
              let txt = "";
              if(res[0].gw[a[0].index].length > 0){
                txt += "GW Pro: " + res[0].gw[a[0].index].join(", ");
              }
              if(txt != ""){
                txt +="  |  "
              }
              if(res[1].gw[a[1].index].length > 0){
                txt += "GW Noob: " + res[1].gw[a[1].index].join(", ");
              }
              return txt;
            }
          }
        },
        responsive: true
      }
    };

    var ctx = document.getElementById('canvas').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });

  }

  var getAjax = function(){

    $.ajax({
      url: "/api/kali-ngegoa-per-week.php",
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
  pl.init();
})
