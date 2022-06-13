  <!--jQuery 库-->
  <script src="{:DIR_STATIC}lib/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
  <script src="{:DIR_STATIC}lib/bootstrap/4.6.0/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  <script src="{:DIR_STATIC}lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_query_global = $('#search_form_global').baigoQuery();

    $('#search_form_global').submit(function(){
      obj_query_global.formSubmit();
    });

    <?php if (isset($cfg['imageAsync'])) { ?>
      $('[data-toggle="async"]').each(function(){
        var _src = $(this).data('src');
        $(this).attr('src', _src);

        $(this).one('error', function(){
          $(this).attr('src', '{:DIR_STATIC}image/notfound.svg');
        });
      });
    <?php } ?>
  });
  </script>
