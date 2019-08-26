var pl = function (){

  var afterReq = function( res, arGW ){

    var config = {
      type: 'line',
      data: {
        labels: arGW,
        datasets: res
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Total Point per Week'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          itemSort: (a, b, data) => b.yLabel - a.yLabel
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Game Week'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Point Hoki'
            }
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
      url: "/api/total-point-per-week.php",
      dataType: 'JSON',
      type: 'GET'
    }).done( (res) => {
      let gw = res[0].data.length;
      let arGW = []
      for(var i = 1; i <= gw; i++){
        arGW.push(i)
      }
    
      afterReq(res, arGW);
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
