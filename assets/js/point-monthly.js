var pl_point_monthly = function (){

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
      "May",
      "June",
      "July",
      "Aug"
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
          display: false,
          text: 'Point Monthly'
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
              display: false,
              labelString: 'Month'
            }
          }]
        }
      }
    };

    var ctx = document.getElementById('canvas_point_monthly').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });

  }

  var getAjax = function(){

    $.ajax({
      url: "/api/point-monthly.php",
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
  pl_point_monthly.init();
})
