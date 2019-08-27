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
          text: 'Kali Underdog'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          callbacks: {
            footer : function(a, b){
              if(res[0].gw[a[0].index].length > 0){
                return "GW: " + res[0].gw[a[0].index].join(", ");
              }
            }
          }
        },
        responsive: true,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
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
      url: "/api/kali-noob-klasemen-per-week.php",
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
