  <div class="modal fade" id="keep_tag_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title"><?php echo $lang->get('Retained tags'); ?></div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <ul class="list-inline">
            <?php foreach ($keepTag as $_key=>$_value) { ?>
              <li class="list-inline-item lead">
                <span class="badge badge-info"><?php echo $_value; ?></span>
              </li>
            <?php } ?>
          </ul>
          <div><?php echo $lang->get('These tags are automatically retained'); ?></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <?php echo $lang->get('Close', 'console.common'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="keep_attr_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title"><?php echo $lang->get('System retains specific attributes of these tags by default'); ?></div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <table class="table table-hover">
          <thead>
            <tr>
              <th><?php echo $lang->get('Tag'); ?></th>
              <th><?php echo $lang->get('Attributes'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($keepAttr as $key=>$value) { ?>
              <tr>
                <td><?php echo $key; ?></td>
                <td class="text-danger">
                  <ul class="list-inline">
                    <?php foreach ($value as $key_attr=>$value_attr) { ?>
                      <li class="list-inline-item">
                        <code><?php echo $value_attr; ?></code>
                      </li>
                    <?php } ?>
                  </ul>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <?php echo $lang->get('Close', 'console.common'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="help_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
  </div>

  <script type="text/javascript">
  function replaceAdd(type) {
    var count = $('#' + type + '_replace > div:last').data('count');
    if (typeof count == 'undefined' || isNaN(count)) {
      count = 0;
    } else {
      ++count;
    }

    $('#' + type + '_replace').append('<div id="' + type + '_replace_group_' + count + '" class="form-row" data-count="' + count + '">' +
      '<div class="form-group col-lg-6">' +
        '<div class="input-group">' +
          '<div class="input-group-prepend">' +
            '<span class="input-group-text"><?php echo $lang->get('Search'); ?></span>' +
          '</div>' +
          '<input type="text" name="gsite_' + type + '_replace[' + count + '][search]" id="gsite_' + type + '_replace_' + count + '_search" class="form-control">' +
        '</div>' +
      '</div>' +
      '<div class="form-group col-lg-6">' +
        '<div class="input-group">' +
          '<div class="input-group-prepend">' +
            '<span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>' +
          '</div>' +
          '<input type="text" name="gsite_' + type + '_replace[' + count + '][replace]" id="gsite_' + type + '_replace_' + count + '_replace" class="form-control">' +
          '<span class="input-group-append">' +
            '<button type="button" data-count="' + count + '" data-type="' + type + '" class="btn btn-info replace_del">' +
              '<span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>' +
            '</button>' +
          '</span>' +
        '</div>' +
      '</div>' +
    '</div>');
  }

  function replaceDel(count, replace) {
    $('#' + replace + '_replace_group_' + count).remove();
  }

  $(document).ready(function(){
    $('#help_modal').on('shown.bs.modal', function(event){
      var _obj_button   = $(event.relatedTarget);
      var _href         = _obj_button.data('href');
      var _size         = _obj_button.data('size');

      $('#help_modal .modal-dialog').addClass('modal-' + _size);
      $('#help_modal .modal-content').load(_href);
    }).on('hidden.bs.modal', function(event){
      $('#help_modal .modal-dialog').removeClass('modal-sm modal-lg modal-xl');
      $('#help_modal .modal-content').empty();
    });

    $('.replace_add').click(function(){
      var _type = $(this).data('type');
      replaceAdd(_type);
    });

    $('.replace_box').on('click', '.replace_del', function(){
      var _count = $(this).data('count');
      var _type = $(this).data('type');
      replaceDel(_count, _type);
    });
  });
  </script>
