<?php $cfg = array(
  'title'         => $albumRow['album_name'],
  'imageAsync'    => 'true',
);

include($tpl_include . 'index_head' . GK_EXT_TPL); ?>

  <h3><?php echo $albumRow['album_name']; ?></h3>

  <div class="card-columns">
    <?php foreach ($attachRows as $key=>$value) { ?>
      <div class="card">
        <a href="#attach_modal" data-toggle="modal" data-url="<?php echo $value['attach_url']; ?>">
          <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['thumb_default']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="card-img-top" id="img_<?php echo $value['attach_id']; ?>">
        </a>
        <div class="card-body">
          <a href="#attach_modal" data-toggle="modal" data-url="<?php echo $value['attach_url']; ?>">
            <?php echo $value['attach_name']; ?>
          </a>
          <div><?php echo $value['attach_time_format']['date_time']; ?></div>
        </div>
      </div>
    <?php } ?>
  </div>

  <?php include($tpl_include . 'pagination' . GK_EXT_TPL);

include($tpl_include . 'index_foot' . GK_EXT_TPL); ?>

  <div class="modal fade" id="attach_modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#attach_modal').on('shown.bs.modal',function(event){
      var _obj_button   = $(event.relatedTarget);
      var _url          = _obj_button.data('url');
      var _html         = '<img src="' + _url + '" class="w-100">';

      $('#attach_modal .modal-body').html(_html);
    }).on('hidden.bs.modal', function(){
      $('#attach_modal .modal-body').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
