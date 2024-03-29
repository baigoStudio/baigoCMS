  <div class="modal fade" id="store_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <span class="spinner-grow spinner-grow-sm"></span>
            <?php echo $lang->get('Being stored'); ?>
          </div>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>
        <div class="embed-responsive embed-responsive-1by1">
          <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <?php echo $lang->get('Close', 'console.common'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#store_modal').on('shown.bs.modal',function(event){
      var _ids        = [];
      var _str_ids    = 0;
      var _obj_button = $(event.relatedTarget);
      var _all        = _obj_button.data('all');
      var _id         = _obj_button.data('id');
      var _enforce    = _obj_button.data('enforce');
      var _arr_ids    = $('.gather_id:checked').serializeArray();

      if (typeof _id != 'undefined' &&  _id > 0) {
        _ids.push(_id);
      } else {
        $.each(_arr_ids, function(key, value){
          _ids.push(value.value);
        });
      }

      var _url = '<?php echo $hrefRow['store']; ?>';

      if (typeof _ids != 'undefined' &&  _ids.length > 0) {
        _str_ids = _ids.toString();
      }

      if (typeof _enforce == 'undefined' ||  _enforce.length  < 1) {
        _enforce = 0;
      }

      if (typeof _all == 'undefined' ||  _all.length  < 1) {
        _all     = 0;
      }

      _url = _url.replace('{:ids}', _str_ids);
      _url = _url.replace('{:enforce}', _enforce);
      _url = _url.replace('{:all}', _all);

      $('#store_modal iframe').attr('src', _url);
    }).on('hidden.bs.modal', function(){
      $('#store_modal iframe').attr('src', '');
    });
  });
  </script>
