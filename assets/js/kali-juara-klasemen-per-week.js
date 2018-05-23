var pl = function (){

  var afterReq = function( res ){

    var config = {
      type: 'line',
      data: {
        labels: [ 'Aji', 'Filar', 'Selamat', 'Enye', 'Bala', 'Indra' ],
        datasets: res
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Kali Juara Klasemen per Week'
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
              labelString: 'Para Noob'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Kali Hoki'
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
      url: "/api/kali-juara-klasemen-per-week.php",
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
