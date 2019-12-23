var pl_total = function (){

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
          text: 'Total Point Weekly'
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

    var ctx = document.getElementById('canvas_total').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });

  }

  var getAjax = function(){

    $.ajax({
      url: "/api/total-point-weekly.php",
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
  pl_total.init();
})
