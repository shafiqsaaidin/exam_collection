    <script src="js/materialize.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script>
      $(document).ready(function(){
        // $('.sidenav-trigger').sideNav();
        $('.collapsible').collapsible();
        $('.modal').modal();
        $('.tooltipped').tooltip();


        // Search
        $('#search').on('keyup', function() {
          var value = $(this).val();
          var patt = new RegExp(value, "i");
            $('#myTable').find('tr').each(function() {
              if (!($(this).find('td').text().search(patt) >= 0)) {
                $(this).not('.myHead').hide();
              }
              if (($(this).find('td').text().search(patt) >= 0)) {
                $(this).show();
              }
            });
        });

        // pie chart
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                  <?php foreach ($words as $x): ?>
                    "<?php echo $x; ?>",
                  <?php endforeach ?>
                ],
                datasets: [{
                    label: '# of Votes',
                    data: [
                      <?php foreach ($string as $y):?>
                        "<?php echo $y?>",
                      <?php endforeach ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {

            }
        });
      });
    </script>
  </body>
</html>