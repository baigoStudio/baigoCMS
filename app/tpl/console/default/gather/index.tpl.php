<?php $cfg = array(
  'title'             => $lang->get('Gathering', 'console.common') . ' &raquo; ' . $lang->get('Approve', 'console.common'),
  'menu_active'       => 'gather',
  'sub_active'        => 'approve',
  'baigoValidate'    => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
  'tooltip'           => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <?php include($tpl_include . 'gather_menu' . GK_EXT_TPL); ?>

    <form name="gather_search" id="gather_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
      <div class="input-group mb-3">
        <input type="text" name="key" value="<?php echo $search['key']; ?>" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
        <span class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">
            <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
          </button>
          <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more">
            <span class="sr-only">Dropdown</span>
          </button>
        </span>
      </div>
      <div class="collapse" id="bg-search-more">
        <div class="input-group mb-3">
          <select name="gsite" class="custom-select">
            <option value=""><?php echo $lang->get('All sites'); ?></option>
            <?php foreach ($gsiteRows as $_key=>$_value) { ?>
              <option <?php if ($_value['gsite_id'] == $search['gsite']) { ?>selected<?php } ?> value="<?php echo $_value['gsite_id']; ?>"><?php echo $_value['gsite_name']; ?></option>
            <?php } ?>
          </select>
          <select name="cate" class="custom-select">
            <option value=""><?php echo $lang->get('All categories'); ?></option>
            <?php $check_id = $search['cate'];
            include($tpl_include . 'cate_list_option' . GK_EXT_TPL); ?>
          </select>
        </div>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key']) || $search['cate'] > 0 || $search['gsite'] > 0) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php }

      if (!empty($search['gsite'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Site'); ?>:
          <?php if ($search['gsite'] < 0) {
            echo $lang->get('Not affiliated');
          } else {
            if (isset($gsiteRow['gsite_name'])) {
              echo $gsiteRow['gsite_name'];
            } else {
              echo $search['gsite'];
            }
          } ?>
        </span>
      <?php }

      if (!empty($search['cate'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Category'); ?>:
          <?php if ($search['cate'] < 0) {
            echo $lang->get('Not affiliated');
          } else {
            if (isset($cateRow['cate_name'])) {
              echo $cateRow['cate_name'];
            } else {
              echo $search['cate'];
            }
          } ?>
        </span>
      <?php } ?>

      <a href="<?php echo $hrefRow['index']; ?>" class="badge badge-danger badge-pill">
        <span class="bg-icon"><?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Reset'); ?>
      </a>
    </div>
  <?php } ?>

  <div class="card bg-light mb-3">
    <div class="card-body">
      <button class="btn btn-primary" data-toggle="modal" data-target="#store_modal" data-all="all">
        <span class="bg-icon"><?php include($tpl_icon . 'save' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Store all'); ?>
      </button>
    </div>
  </div>

  <form name="gather_list" id="gather_list" action="<?php echo $hrefRow['delete']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">

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
              <?php echo $lang->get('Gathering'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md">
              <small>
                <?php echo $lang->get('Site'); ?>
                /
                <?php echo $lang->get('Category'); ?>
              </small>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
                /
                <?php echo $lang->get('Time'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gatherRows as $key=>$value) {
            $str_cateBeadcrumb = '';

            if (isset($value['cateRow']['cate_breadcrumb'])) {
              foreach ($value['cateRow']['cate_breadcrumb'] as $key_cate=>$value_cate) {
                $str_cateBeadcrumb .= $value_cate['cate_name'];

                if ($value_cate['cate_end'] < 1) {
                  $str_cateBeadcrumb .= ' &raquo; ';
                }
              }
            } ?>
            <tr class="bg-manage-tr">
              <td class="text-nowrap bg-td-xs">
                <div class="form-check">
                  <input type="checkbox" name="gather_ids[]" value="<?php echo $value['gather_id']; ?>" id="gather_id_<?php echo $value['gather_id']; ?>" data-parent="chk_all" data-validate="gather_ids" class="form-check-input gather_id">
                  <label for="gather_id_<?php echo $value['gather_id']; ?>" class="form-check-label">
                    <small><?php echo $value['gather_id']; ?></small>
                  </label>
                </div>
              </td>
              <td>
                <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['gather_id']; ?>">
                  <span class="sr-only">Dropdown</span>
                </a>
                <div class="mb-2 text-wrap text-break">
                  <?php echo $value['gather_title']; ?>
                </div>
                <div class="bg-manage-menu">
                  <div class="d-flex flex-wrap">
                    <a href="<?php echo $hrefRow['show'], $value['gather_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Show'); ?>
                    </a>
                    <a href="#store_modal" data-toggle="modal" data-id="<?php echo $value['gather_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'save' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Store'); ?>
                    </a>
                    <a href="<?php echo $hrefRow['article-add'], $value['gather_id']; ?>" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Edit and store'); ?>
                    </a>
                    <a href="#store_modal" data-toggle="modal" data-id="<?php echo $value['gather_id']; ?>" data-enforce="enforce" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'save' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Store enforce'); ?>
                    </a>
                    <a href="javascript:void(0);" data-id="<?php echo $value['gather_id']; ?>" class="gather_delete text-danger">
                      <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Delete'); ?>
                    </a>
                  </div>
                </div>
                <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['gather_id']; ?>">
                  <dt class="col-3">
                    <small><?php echo $lang->get('Site'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php if (isset($value['gsiteRow']['gsite_name'])) { ?>
                      <small><?php echo $value['gsiteRow']['gsite_name']; ?></small>
                    <?php } ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Category'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php if (isset($value['cateRow']['cate_name'])) { ?>
                      <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                        <?php echo $value['cateRow']['cate_name']; ?>
                      </small>
                    <?php } ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Status'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <?php $str_status = $value['gather_status'];
                    include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                  </dd>
                  <dt class="col-3">
                    <small><?php echo $lang->get('Time'); ?></small>
                  </dt>
                  <dd class="col-9">
                    <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['gather_time_show_format']['date_time']; ?>"><?php echo $value['gather_time_show_format']['date_time_short']; ?></small>
                  </dd>
                </dl>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md">
                <small>
                  <div class="mb-2">
                    <?php if (isset($value['gsiteRow']['gsite_name'])) {
                      echo $value['gsiteRow']['gsite_name'];
                    } ?>
                  </div>
                  <?php if (isset($value['cateRow']['cate_name'])) { ?>
                    <abbr data-toggle="tooltip" data-placement="bottom" title="<?php echo $str_cateBeadcrumb; ?>">
                      <?php echo $value['cateRow']['cate_name']; ?>
                    </abbr>
                  <?php } ?>
                </small>
              </td>
              <td class="d-none d-lg-table-cell bg-td-md text-right">
                <div class="mb-2">
                  <?php $str_status = $value['gather_status'];
                  include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                </div>
                <div>
                  <small data-toggle="tooltip" data-placement="bottom" title="<?php echo $value['gather_time_show_format']['date_time']; ?>"><?php echo $value['gather_time_show_format']['date_time_short']; ?></small>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_gather_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="btn-toolbar mb-3">
          <div class="btn-group mr-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#store_modal"><?php echo $lang->get('Store'); ?></button>
            <button type="submit" class="btn btn-outline-secondary"><?php echo $lang->get('Delete'); ?></button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#store_modal" data-enforce="enforce"><?php echo $lang->get('Store enforce'); ?></button>
          </div>
        </div>
        <small id="msg_act" class="form-text"></small>
      </div>
      <div class="float-right">
        <?php include($tpl_include . 'pagination' . GK_EXT_TPL); ?>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL);

  include($tpl_ctrl . 'gather_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      gather_ids: {
        checkbox: '1'
      }
    },
    attr_names: {
      gather_ids: '<?php echo $lang->get('Gathering'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      gather_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#gather_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#gather_list').baigoSubmit(opts_submit);

    $('#gather_list').submit(function(){
      if (obj_validate_list.verify()) {
        obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
          if (confirm_result) {
            obj_submit_list.formSubmit();
          }
        });
      }
    });

    $('.gather_delete').click(function(){
      var _gather_id = $(this).data('id');
      $('.gather_id').prop('checked', false);
      $('#gather_id_' + _gather_id).prop('checked', true);
      $('#gather_list').submit();
    });

    $('#gather_list').baigoCheckall();

    var obj_query = $('#gather_search').baigoQuery();

    $('#gather_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
