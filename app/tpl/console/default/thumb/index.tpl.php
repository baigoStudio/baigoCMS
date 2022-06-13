<?php $cfg = array(
  'title'             => $lang->get('Attachment', 'console.common') . ' &raquo; ' . $lang->get('Thumbnails', 'console.common'),
  'menu_active'       => 'attach',
  'sub_active'        => 'thumb',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoDialog'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['add']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Add'); ?>
    </a>
  </nav>

  <div class="card bg-light mb-3">
    <div class="card-body">
      <form name="thumb_cache" id="thumb_cache" action="<?php echo $hrefRow['cache']; ?>">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <button type="submit" class="btn btn-primary">
          <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Refresh cache'); ?>
        </button>
      </form>
    </div>
  </div>

  <form name="thumb_list" id="thumb_list" action="<?php echo $hrefRow['delete']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="act" id="act" value="delete">

    <div class="table-responsive">
      <table class="table table-striped border bg-white">
        <thead>
          <tr>
            <th class="text-nowrap bg-td-xs">
              <div class="form-check">
                <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                <label for="chk_all" class="form-check-label">
                  <small><?php echo $lang->get('ID'); ?></small>
                </label>
              </div>
            </th>
            <th>
              <?php echo $lang->get('Thumbnail'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
                /
                <?php echo $lang->get('Type'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($thumbRows as $key=>$value) { ?>
            <tr class="bg-manage-tr<?php if ($value['thumb_id'] < 1) { ?> table-active<?php } ?>">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="thumb_ids[]" value="<?php echo $value['thumb_id']; ?>" id="thumb_id_<?php echo $value['thumb_id']; ?>" data-parent="chk_all" data-validate="thumb_ids" class="form-check-input thumb_id" <?php if ($value['thumb_id'] < 1) { ?>disabled<?php } ?>>
                  <label for="thumb_id_<?php echo $value['thumb_id']; ?>" class="form-check-label" >
                    <small><?php echo $value['thumb_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['thumb_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['thumb_id']; ?>">
                    <?php echo $value['thumb_width']; ?> X <?php echo $value['thumb_height']; ?>
                  </a>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <?php if ($value['thumb_id'] > 0) { ?>
                      <a href="<?php echo $hrefRow['show'], $value['thumb_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Show'); ?>
                      </a>
                      <a href="#modal_nm" data-toggle="modal" data-href="<?php echo $hrefRow['edit'], $value['thumb_id']; ?>" class="mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Edit'); ?>
                      </a>
                      <a href="javascript:void(0);" data-id="<?php echo $value['thumb_id']; ?>" class="thumb_default mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Set as default'); ?>
                      </a>
                      <a href="javascript:void(0);" data-id="<?php echo $value['thumb_id']; ?>" class="thumb_delete text-danger mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Delete'); ?>
                      </a>
                      <a href="<?php echo $hrefRow['show'], $value['thumb_id']; ?>">
                        <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Regenerate thumbnails'); ?>
                      </a>
                    <?php } else { ?>
                      <span class="mr-2 text-muted">
                        <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Show'); ?>
                      </span>
                      <span class="mr-2 text-muted">
                        <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Edit'); ?>
                      </span>
                      <a href="javascript:void(0);" data-id="<?php echo $value['thumb_id']; ?>" class="thumb_default mr-2">
                        <span class="bg-icon"><?php include($tpl_icon . 'image' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Set as default'); ?>
                      </a>
                      <span class="text-muted">
                        <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                        <?php echo $lang->get('Delete'); ?>
                      </span>
                    <?php } ?>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['thumb_id']; ?>">
                  <?php if ($config['var_extra']['base']['site_thumb_default'] == $value['thumb_id']) { ?>
                    <dt class="col-3">
                      <small><?php echo $lang->get('Status'); ?></small>
                    </dt>
                    <dd class="col-9">
                      <span class="badge badge-info"><?php echo $lang->get('Default'); ?></span>
                    </dd>
                  <?php } ?>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Type'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small><?php echo $lang->get($value['thumb_type']); ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <?php if ($config['var_extra']['base']['site_thumb_default'] == $value['thumb_id']) { ?>
                  <div>
                    <span class="badge badge-info"><?php echo $lang->get('Default'); ?></span>
                  </div>
                <?php } ?>
                <div>
                  <small><?php echo $lang->get($value['thumb_type']); ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_thumb_ids"></small>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">
        <?php echo $lang->get('Delete'); ?>
      </button>
    </div>
  </form>

  <form name="thumb_default" id="thumb_default" action="<?php echo $hrefRow['set-default']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="thumb_id" id="thumb_id" value="0">
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_include . 'modal_nm' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      thumb_ids: {
        checkbox: '1'
      }
    },
    attr_names: {
      thumb_ids: '<?php echo $lang->get('Thumbnail'); ?>'
    },
    type_msg: {
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      thumb_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#thumb_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#thumb_list').baigoSubmit(opts_submit);

    $('#thumb_list').submit(function(){
      if (obj_validate_list.verify()) {
        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
          if (confirm_result) {
            obj_submit_list.formSubmit();
          }
        });
      }
    });

    var obj_cache = $('#thumb_cache').baigoSubmit(opts_submit);
    $('#thumb_cache').submit(function(){
      obj_cache.formSubmit();
    });

    $('.thumb_default').click(function(){
      var obj_submit_default = $('#thumb_default').baigoSubmit(opts_submit);
      var _thumb_id = $(this).data('id');
      $('#thumb_id').val(_thumb_id);
      obj_submit_default.formSubmit();
    });

    $('.thumb_delete').click(function(){
      var _thumb_id = $(this).data('id');
      $('.thumb_id').prop('checked', false);
      $('#thumb_id_' + _thumb_id).prop('checked', true);
      $('#thumb_list').submit();
    });

    $('#thumb_list').baigoCheckall();
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
