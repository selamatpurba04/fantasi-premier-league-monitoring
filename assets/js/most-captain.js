var pl_capt = function (){

  var afterReq = function( res ){

    var barChartData = {
      labels: temp_name,
      datasets: res.data
    };

    var config = {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: false,
          text: 'Most Picked Captain'
        },
        tooltips: {
          mode: 'index',
          intersect: false
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

    var ctx = document.getElementById('canvas_capt').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });
  }

  var getAjax = function(){

    $.ajax({
      url: "/api/most-captain.php",
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
  pl_capt.init();
})
