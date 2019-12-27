var pl_point_weekly = function (){

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
          text: 'Point Weekly'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          itemSort: (a, b, data) => b.yLabel - a.yLabel,
          callbacks: {
            afterBody: function(dI, dA) {
              let chips = [];
              chips.push('');
              for(var i in dI){
                let chps = dA.datasets[ dI[i].datasetIndex ].chips[ dI[i].index ];
                let name = dA.datasets[ dI[i].datasetIndex ].label;
                if(chps !== null){
                  chips.push( name + ': ' + chps.charAt(0).toUpperCase() + chps.slice(1));
                }
              }
  
              return chips;
            }
          }
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

    var ctx = document.getElementById('canvas_point_weekly').getContext('2d');
    var myLine = new Chart(ctx, config);
    myLine.render({
        duration: 2000,
        lazy: false,
        easing: 'easeOutBounce'
    });

  }

  var getAjax = function(){

    $.ajax({
      url: "/api/point-weekly.php",
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
  pl_point_weekly.init();
})
