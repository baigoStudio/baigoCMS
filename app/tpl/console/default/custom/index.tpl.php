<?php
if (!function_exists('custom_list_table')) {
  function custom_list_table($arr_customRows, $lang = '', $hrefRow = array(), $cfg = '', $tpl_include = '', $tpl_icon = '') {
    if (!empty($arr_customRows)) {
      foreach ($arr_customRows as $key=>$value) { ?>
        <tr class="bg-manage-tr">
          <td class="text-nowrap bg-td-xs">
            <div class="form-check">
              <input type="checkbox" name="custom_ids[]" value="<?php echo $value['custom_id']; ?>" id="custom_id_<?php echo $value['custom_id']; ?>" data-validate="custom_ids" data-parent="chk_all" class="form-check-input custom_id">
              <label for="custom_id_<?php echo $value['custom_id']; ?>" class="form-check-label">
                <small><?php echo $value['custom_id']; ?></small>
              </label>
            </div>
          </td>
          <td>
            <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['custom_id']; ?>">
              <span class="sr-only">Dropdown</span>
            </a>
            <div class="mb-2 text-wrap text-break">
              <?php if (isset($value['custom_level']) && $value['custom_level'] > 1) {
                for ($_iii = 1; $_iii < $value['custom_level']; ++$_iii) { ?>
                &mdash;
                <?php }
              } ?>
              <a href="<?php echo $hrefRow['edit'], $value['custom_id']; ?>">
              <?php if (empty($value['custom_name'])) {
                echo $lang->get('Unnamed');
              } else {
                echo $value['custom_name'];
              } ?>
              </a>
            </div>

            <div class="bg-manage-menu">
              <div class="d-flex flex-wrap">
                <a href="<?php echo $hrefRow['show'], $value['custom_id']; ?>" class="mr-2">
                  <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Show'); ?>
                </a>
                <a href="<?php echo $hrefRow['edit'], $value['custom_id']; ?>" class="mr-2">
                  <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Edit'); ?>
                </a>
                <a href="javascript:void(0);" data-id="<?php echo $value['custom_id']; ?>" class="custom_delete text-danger mr-2">
                  <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('Delete'); ?>
                </a>
                <?php if (isset($value['custom_childs']) && !empty($value['custom_childs'])) { ?>
                  <a href="<?php echo $hrefRow['order'], $value['custom_id']; ?>">
                    <span class="bg-icon"><?php include($tpl_icon . 'sort-amount-up' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Sort'); ?>
                  </a>
                <?php } ?>
              </div>
            </div>
            <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['custom_id']; ?>">
              <dt class="col-3">
                <small><?php echo $lang->get('Status'); ?></small>
              </dt>
              <dd class="col-9">
                <?php $str_status = $value['custom_status'];
                include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
              </dd>
            </dl>
          </td>
          <td class="d-none d-lg-table-cell bg-td-md text-right">
            <?php $str_status = $value['custom_status'];
            include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
          </td>
        </tr>

        <?php if (isset($value['custom_childs'])) {
          custom_list_table($value['custom_childs'], $lang, $hrefRow, $cfg, $tpl_include, $tpl_icon);
        }
      }
    }
  }
}


$cfg = array(
  'title'             => $lang->get('Article management', 'console.common') . ' &raquo; ' . $lang->get('Custom fields', 'console.common'),
  'menu_active'       => 'article',
  'sub_active'        => 'custom',
  'baigoValidate'     => 'true',
  'baigoSubmit'       => 'true',
  'baigoCheckall'     => 'true',
  'baigoQuery'        => 'true',
  'baigoDialog'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <div class="d-flex justify-content-between">
    <nav class="nav mb-3">
      <a href="<?php echo $hrefRow['add']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Add'); ?>
      </a>
      <a href="<?php echo $hrefRow['order']; ?>" class="nav-link">
        <span class="bg-icon"><?php include($tpl_icon . 'sort-alpha-up' . BG_EXT_SVG); ?></span>
        <?php echo $lang->get('Sort'); ?>
      </a>
    </nav>
    <form name="custom_search" id="custom_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
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
          <select name="status" class="custom-select">
            <option value=""><?php echo $lang->get('All status'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option <?php if ($search['status'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
  </div>

  <?php if (!empty($search['key']) || !empty($search['status']) || !empty($search['type'])) { ?>
    <div class="mb-3 text-right">
      <?php if (!empty($search['key'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Keyword'); ?>:
          <?php echo $search['key']; ?>
        </span>
      <?php }

      if (!empty($search['status'])) { ?>
        <span class="badge badge-info">
          <?php echo $lang->get('Status'); ?>:
          <?php echo $lang->get($search['status']); ?>
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
      <form name="custom_cache" id="custom_cache" action="<?php echo $hrefRow['cache']; ?>">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <button type="submit" class="btn btn-primary">
          <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Refresh cache'); ?>
        </button>
      </form>
    </div>
  </div>

  <form name="custom_list" id="custom_list" action="<?php echo $hrefRow['status']; ?>">
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
              <?php echo $lang->get('Field'); ?>
            </th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php custom_list_table($customRows, $lang, $hrefRow, $cfg, $tpl_include, $tpl_icon); ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_custom_ids"></small>
    </div>

    <div class="clearfix">
      <div class="float-left">
        <div class="input-group mb-3">
          <select name="act" id="act" class="custom-select">
            <option value=""><?php echo $lang->get('Bulk actions'); ?></option>
            <?php foreach ($status as $key=>$value) { ?>
              <option value="<?php echo $value; ?>">
                <?php echo $lang->get($value); ?>
              </option>
            <?php } ?>
            <option value="delete"><?php echo $lang->get('Delete'); ?></option>
          </select>
          <span class="input-group-append">
            <button type="submit" class="btn btn-primary">
              <?php echo $lang->get('Apply'); ?>
            </button>
          </span>
        </div>
        <small id="msg_act" class="form-text"></small>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var opts_validate_list = {
    rules: {
      custom_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      custom_ids: '<?php echo $lang->get('Field'); ?>'
    },
    type_msg: {
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      custom_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#custom_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#custom_list').baigoSubmit(opts_submit);

    $('#custom_list').submit(function(){
      var _act = $('#act').val();
      if (obj_validate_list.verify()) {
        switch (_act) {
          case 'delete':
            obj_dialog.confirm('<?php echo $lang->get('Are you sure to delete?'); ?>', function(confirm_result){
              if (confirm_result) {
                obj_submit_list.formSubmit('<?php echo $hrefRow['delete']; ?>');
              }
            });
          break;

          default:
            obj_submit_list.formSubmit('<?php echo $hrefRow['status']; ?>');
          break;
        }
      }
    });

    var obj_cache = $('#custom_cache').baigoSubmit(opts_submit);
    $('#custom_cache').submit(function(){
      obj_cache.formSubmit();
    });

    $('.custom_delete').click(function(){
      var _custom_id = $(this).data('id');
      $('.custom_id').prop('checked', false);
      $('#custom_id_' + _custom_id).prop('checked', true);
      $('#act').val('delete');
      $('#custom_list').submit();
    });

    $('#custom_list').baigoCheckall();

    var obj_query = $('#custom_search').baigoQuery();

    $('#custom_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
