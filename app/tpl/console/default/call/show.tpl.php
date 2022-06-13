<?php $cfg = array(
  'title'             => $lang->get('Call', 'console.common') . ' &raquo; ' . $lang->get('Show'),
  'menu_active'       => 'call',
  'sub_active'        => 'index',
  'baigoSubmit'       => 'true',
);

include($tpl_include . 'console_head' . GK_EXT_TPL); ?>

  <nav class="nav mb-3">
    <a href="<?php echo $hrefRow['index']; ?>" class="nav-link">
      <span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span>
      <?php echo $lang->get('Back'); ?>
    </a>
  </nav>

  <form name="call_form" id="call_form" action="<?php echo $hrefRow['duplicate']; ?>">
    <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
    <input type="hidden" name="call_id" id="call_id" value="<?php echo $callRow['call_id']; ?>">

    <div class="row">
      <div class="col-xl-9">
        <div class="card mb-3">
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Suggested calling code'); ?></label>
              <div class="form-text font-weight-bolder">
                <code>
                  <?php echo $callRow['call_code']; ?>
                </code>
              </div>
            </div>

            <?php if ($gen_open === true) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('URL'); ?></label>
                <div class="form-text font-weight-bolder">
                  <code>
                    <?php echo $callRow['call_url']; ?>
                  </code>
                </div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Path'); ?></label>
                <div class="form-text font-weight-bolder">
                  <code>
                    <?php echo $callRow['call_path']; ?>
                  </code>
                </div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $callRow['call_name']; ?></div>
            </div>

            <?php if ($callRow['call_type'] == 'cate') {
              if ($callRow['call_cate_id'] < 1) {
                $str_color = 'primary';
                $str_icon  = 'check-circle';
              } else {
                $str_color = 'muted';
                $str_icon  = 'times-circle';
              } ?>
              <div class="alert alert-success">
                <span class="bg-icon"><?php include($tpl_icon . 'filter' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Filter'); ?>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Category'); ?></label>
                <div class="form-text text-<?php echo $str_color; ?>">
                  <span class="bg-icon"><?php include($tpl_icon . $str_icon . BG_EXT_SVG); ?></span>
                  <?php echo $lang->get('All categories'); ?>
                </div>
                <table class="bg-table">
                  <tbody>
                    <?php $cate_id = $callRow['call_cate_id'];
                    $cate_excepts = $callRow['call_cate_excepts'];
                    //$lang = $callRow['call_cate_excepts'];
                    $is_edit = false;
                    include($tpl_include . 'cate_list_radio' . GK_EXT_TPL); ?>
                  </tbody>
                </table>
              </div>
            <?php } else if ($callRow['call_type'] != 'spec' && $callRow['call_type'] != 'tag_list' && $callRow['call_type'] != 'tag_rank' && $callRow['call_type'] != 'link') { ?>
              <div class="alert alert-success">
                <span class="bg-icon"><?php include($tpl_icon . 'filter' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Filter'); ?>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Category'); ?></label>
                <table class="bg-table">
                  <tbody>
                    <?php $cate_ids = $callRow['call_cate_ids'];
                    $is_edit = false;
                    include($tpl_include . 'cate_list_checkbox' . GK_EXT_TPL); ?>
                  </tbody>
                </table>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Special topic'); ?></label>
                <div>
                  <?php foreach ($specRows as $key=>$value) { ?>
                    <div class="input-group mb-2" id="spec_item_<?php echo $value['spec_id']; ?>">
                      <div class="input-group-prepend">
                        <div class="input-group-text border-success">
                          <span class="bg-icon text-primary"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>
                        </div>
                      </div>
                      <input type="text" class="form-control border-success bg-transparent" readonly value="<?php echo $value['spec_name']; ?>">
                    </div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('With pictures'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php echo $lang->get($callRow['call_attach']); ?>
                </div>
              </div>

              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Mark'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php foreach ($markRows as $key=>$value) {
                      if (in_array($value['mark_id'], $callRow['call_mark_ids'])) {
                        $str_color = 'primary';
                        $str_icon  = 'check-circle';
                      } else {
                        $str_color = 'muted';
                        $str_icon  = 'times-circle';
                      } ?>
                      <div class="text-<?php echo $str_color; ?>">
                        <span class="bg-icon"><?php include($tpl_icon . $str_icon . BG_EXT_SVG); ?></span>
                        <?php echo $value['mark_name']; ?>
                      </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">
                <?php echo $lang->get('Duplicate'); ?>
              </button>

              <a href="<?php echo $hrefRow['edit'], $callRow['call_id']; ?>">
                <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
                <?php echo $lang->get('Edit'); ?>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3">
        <div class="card bg-light">
          <div class="card-body">
            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
              <div class="form-text font-weight-bolder"><?php echo $callRow['call_id']; ?></div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
              <div class="form-text font-weight-bolder">
                <?php echo $lang->get($callRow['call_status']); ?>
              </div>
            </div>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Type'); ?></label>
              <div class="form-text font-weight-bolder">
                <?php echo $lang->get($callRow['call_type']); ?>
              </div>
            </div>

            <?php if ($gen_open === true) { ?>
              <div class="form-group">
                <label class="text-muted font-weight-light"><?php echo $lang->get('Type of generate file'); ?></label>
                <div class="form-text font-weight-bolder">
                  <?php echo $callRow['call_file']; ?>
                </div>
              </div>
            <?php } ?>

            <div class="form-group">
              <label class="text-muted font-weight-light"><?php echo $lang->get('Amount of display'); ?></label>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <?php echo $lang->get('Top'); ?>
                  </div>
                </div>
                <input type="text" value="<?php echo $callRow['call_amount']['top']; ?>" class="form-control" readonly>
              </div>

              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <?php echo $lang->get('Except top'); ?>
                  </div>
                </div>
                <input type="text" value="<?php echo $callRow['call_amount']['except']; ?>" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <a href="<?php echo $hrefRow['edit'], $callRow['call_id']; ?>">
              <span class="bg-icon"><?php include($tpl_icon . 'edit' . BG_EXT_SVG); ?></span>
              <?php echo $lang->get('Edit'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>

<?php include($tpl_include . 'console_foot' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  $(document).ready(function(){
    var obj_submit_form     = $('#call_form').baigoSubmit(opts_submit);

    $('#call_form').submit(function(){
      obj_submit_form.formSubmit();
    });
  });
  </script>

<?php include($tpl_include . 'html_foot' . GK_EXT_TPL);
