var pl_cost_weekly = function (){

  var afterReq = function( datasets, labels ){

    var config = {
      type: 'line',
      data: {
        labels,
        datasets
      },
      options: {
        responsive: true,
        title: {
          display: false,
          text: 'Transfer Cost Weekly'
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
              labelString: 'Game Week'
            }
          }]
        }
      }
    };

    var ctx = document.getElementById('canvas_cost_weekly').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });

  }

  var getAjax = function(){

    $.ajax({
      url: "/api/transfer-cost-weekly.php",
      dataType: 'JSON',
      type: 'GET'
    }).done( (res) => {
      const { currentGW, startGW, datasets } = res;
      let labels = [];
      for(var i = startGW; i <= currentGW; i++){
        labels.push(i);
      }

      afterReq(datasets, labels);
    });

  }

  return{
    init: function() {
      getAjax();
    }
  }

}();

$(document).ready( () => {
  pl_cost_weekly.init();
})
