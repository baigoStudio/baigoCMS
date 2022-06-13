<?php
if (!function_exists('cate_list_table')) {
  function cate_list_table($arr_cateRows, $lang = '', $hrefRow = array(), $cfg = '', $tpl_include = '', $tpl_icon = '', $gen_open = '') {
    if (!empty($arr_cateRows)) {
      if (!empty($arr_cateRows)) {
        foreach ($arr_cateRows as $key=>$value) { ?>
          <tr class="bg-manage-tr">
            <td class="text-nowrap bg-td-xs">
              <div class="form-check">
                <input type="checkbox" name="cate_ids[]" value="<?php echo $value['cate_id']; ?>" id="cate_id_<?php echo $value['cate_id']; ?>" data-validate="cate_ids" data-parent="chk_all" class="form-check-input cate_id">
                <label for="cate_id_<?php echo $value['cate_id']; ?>" class="form-check-label">
                  <small><?php echo $value['cate_id']; ?></small>
                </label>
              </div>
            </td>
            <td>
              <a class="dropdown-toggle float-right d-block d-lg-none" data-toggle="collapse" href="#td-collapse-<?php echo $value['cate_id']; ?>">
                <span class="sr-only">Dropdown</span>
              </a>
              <div class="mb-2 text-wrap text-break">
                <?php if (isset($value['cate_level']) && $value['cate_level'] > 1) {
                  for ($_iii = 1; $_iii < $value['cate_level']; ++$_iii) { ?>
                    &mdash;
                  <?php }
                } ?>
                <a href="<?php echo $hrefRow['edit'], $value['cate_id']; ?>">
                  <?php if (empty($value['cate_name'])) {
                    echo $lang->get('Unnamed');
                  } else {
                    echo $value['cate_name'];
                  } ?>
                </a>
              </div>

              <div class="bg-manage-menu">
                <div class="d-flex flex-wrap">
                  <a href="<?php echo $hrefRow['show'], $value['cate_id']; ?>" class="mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'eye' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Show'); ?>
                  </a>
                  <a href="<?php echo $hrefRow['edit'], $value['cate_id']; ?>" class="mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Edit'); ?>
                  </a>
                  <a href="<?php echo $hrefRow['attach'], $value['cate_id']; ?>" class="mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'images' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Cover management'); ?>
                  </a>
                  <?php if ($gen_open) { ?>
                    <a href="#gen_modal" data-url="<?php echo $hrefRow['gen'], $value['cate_id']; ?>" data-toggle="modal" class="mr-2">
                      <span class="bg-icon"><?php include($tpl_icon . 'sync-alt' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Generate'); ?>
                    </a>
                  <?php } ?>
                  <a href="<?php echo $hrefRow['article-index'], $value['cate_id']; ?>" class="mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'newspaper' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Article management'); ?>
                  </a>
                  <a href="javascript:void(0);" data-id="<?php echo $value['cate_id']; ?>" class="cate_delete text-danger mr-2">
                    <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
                    <?php echo $lang->get('Delete'); ?>
                  </a>
                  <?php if (isset($value['cate_childs']) && !empty($value['cate_childs'])) { ?>
                    <a href="<?php echo $hrefRow['order'], $value['cate_id']; ?>">
                      <span class="bg-icon"><?php include($tpl_icon . 'sort-amount-up' . BG_EXT_SVG); ?></span>
                      <?php echo $lang->get('Sort'); ?>
                    </a>
                  <?php } ?>
                </div>
              </div>
              <dl class="row collapse mt-3 mb-0" id="td-collapse-<?php echo $value['cate_id']; ?>">
                <dt class="col-3">
                  <small><?php echo $lang->get('Status'); ?></small>
                </dt>
                <dd class="col-9">
                  <?php $str_status = $value['cate_status'];
                  include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
                </dd>
                <dt class="col-3">
                  <small><?php echo $lang->get('Alias'); ?></small>
                </dt>
                <dd class="col-9">
                  <small><?php echo $value['cate_alias']; ?></small>
                </dd>
              </dl>
            </td>
            <td class="d-none d-lg-table-cell bg-td-md text-right">
              <div>
                <?php $str_status = $value['cate_status'];
                include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
              </div>
              <div>
                <small><?php echo $value['cate_alias']; ?></small>
              </div>
            </td>
          </tr>

          <?php if (isset($value['cate_childs'])) {
            cate_list_table($value['cate_childs'], $lang, $hrefRow, $cfg, $tpl_include, $tpl_icon, $gen_open);
          }
        }
      }
    }
  }
}

$cfg = array(
  'title'             => $lang->get('Category', 'console.common'),
  'menu_active'       => 'cate',
  'sub_active'        => 'index',
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
    <form name="cate_search" id="cate_search" class="d-none d-lg-block" action="<?php echo $hrefRow['index']; ?>">
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
      <form name="cate_cache" id="cate_cache" action="<?php echo $hrefRow['cache']; ?>">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <button type="submit" class="btn btn-primary">
          <span class="bg-icon"><?php include($tpl_icon . 'redo-alt' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Refresh cache'); ?>
        </button>
      </form>
    </div>
  </div>

  <form name="cate_list" id="cate_list" action="<?php echo $hrefRow['status']; ?>">
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
            <th><?php echo $lang->get('Category'); ?></th>
            <th class="d-none d-lg-table-cell bg-td-md text-right">
              <small>
                <?php echo $lang->get('Status'); ?>
                /
                <?php echo $lang->get('Alias'); ?>
              </small>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php cate_list_table($cateRows, $lang, $hrefRow, $cfg, $tpl_include, $tpl_icon, $gen_open); ?>
        </tbody>
      </table>
    </div>

    <div class="mb-3">
      <small class="form-text" id="msg_cate_ids"></small>
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
      cate_ids: {
        checkbox: '1'
      },
      act: {
        require: true
      }
    },
    attr_names: {
      cate_ids: '<?php echo $lang->get('Category'); ?>',
      act: '<?php echo $lang->get('Action'); ?>'
    },
    type_msg: {
      require: '<?php echo $lang->get('Choose at least one {:attr}'); ?>',
      checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
    },
    selector_types: {
      cate_ids: 'validate'
    }
  };

  $(document).ready(function(){
    var obj_dialog          = $.baigoDialog(opts_dialog);
    var obj_validate_list   = $('#cate_list').baigoValidate(opts_validate_list);
    var obj_submit_list     = $('#cate_list').baigoSubmit(opts_submit);

    $('#cate_list').submit(function(){
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

    var obj_cache = $('#cate_cache').baigoSubmit(opts_submit);
    $('#cate_cache').submit(function(){
      obj_cache.formSubmit();
    });

    $('.cate_delete').click(function(){
      var _cate_id = $(this).data('id');
      $('.cate_id').prop('checked', false);
      $('#cate_id_' + _cate_id).prop('checked', true);
      $('#act').val('delete');
      $('#cate_list').submit();
    });

    $('#cate_list').baigoCheckall();

    var obj_query = $('#cate_search').baigoQuery();

    $('#cate_search').submit(function(){
      obj_query.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
