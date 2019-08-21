var pl = function (){

  var getMonth = function( num ){
    let listMonth = [
      "August",
      "September",
      "October",
      "November",
      "December",
      "January",
      "February",
      "March",
      "April",
      "May"
    ];

    return listMonth[num];
  }
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
          text: 'Point per Week'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
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
      url: "/api/point-per-month.php",
      dataType: 'JSON',
      type: 'GET'
    }).done( (res) => {
      let gw = res[0].data.length;
      let arGW = []
      for(var i = 0; i < gw; i++){
        arGW.push(getMonth(i))
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
