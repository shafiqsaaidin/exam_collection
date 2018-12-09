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
      });
    </script>
  </body>
</html>