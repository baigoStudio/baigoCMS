  <div class="col-xl-3">
    <div class="list-group">
      <?php if ($gsiteRow['gsite_id'] > 0 && $route_orig['act'] != 'show') { ?>
        <a href="<?php echo $hrefRow['edit'], $gsiteRow['gsite_id']; ?>" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'form') { ?> active<?php } ?>">
          <span class="bg-icon bg-fw"><?php include($tpl_icon . 'pen' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Edit'); ?>
        </a>
        <a href="<?php echo $hrefRow['lists'], $gsiteRow['gsite_id']; ?>" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'lists') { ?> active<?php } ?>">
          <span class="bg-icon bg-fw"><?php include($tpl_icon . 'list' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('List settings'); ?>
        </a>
        <a href="<?php echo $hrefRow['content'], $gsiteRow['gsite_id']; ?>" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'content') { ?> active<?php } ?>">
          <span class="bg-icon bg-fw"><?php include($tpl_icon . 'file' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Content settings'); ?>
        </a>
        <a href="<?php echo $hrefRow['page-lists'], $gsiteRow['gsite_id']; ?>" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'page-lists') { ?> active<?php } ?>">
          <span class="bg-icon bg-fw"><?php include($tpl_icon . 'ellipsis-h' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Paging list settings'); ?>
        </a>
        <a href="<?php echo $hrefRow['page-content'],$gsiteRow['gsite_id']; ?>" class="list-group-item list-group-item-action<?php if ($route_orig['act'] == 'page-content') { ?> active<?php } ?>">
          <span class="bg-icon bg-fw"><?php include($tpl_icon . 'scroll' . BG_EXT_SVG); ?></span>
          <?php echo $lang->get('Paging content settings'); ?>
        </a>
      <?php } ?>
      <div class="list-group-item bg-light">
        <?php if ($gsiteRow['gsite_id'] > 0) { ?>
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('ID'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_id']; ?></div>
          </div>
        <?php }

        if ($route_orig['act'] != 'form') { ?>
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php $str_status = $gsiteRow['gsite_status'];
              include($tpl_include . 'status_process' . GK_EXT_TPL); ?>
            </div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Name'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_name']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Note'); ?></label>
            <div class="form-text font-weight-bolder"><?php echo $gsiteRow['gsite_note']; ?></div>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Belong to category'); ?></label>
            <div class="form-text font-weight-bolder">
              <?php if (isset($cateRow['cate_name'])) {
                echo $cateRow['cate_name'];
              } ?>
            </div>
          </div>
        <?php } else { ?>
          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Belong to category'); ?> <span class="text-danger">*</span></label>
            <select name="gsite_cate_id" id="gsite_cate_id" class="form-control">
              <option value=""><?php echo $lang->get('Please select'); ?></option>
              <?php $check_id = $gsiteRow['gsite_cate_id'];
              include($tpl_include . 'cate_list_option' . GK_EXT_TPL); ?>
            </select>
            <small class="form-text" id="msg_gsite_cate_id"></small>
          </div>

          <div class="form-group">
            <label class="text-muted font-weight-light"><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
            <div>
              <?php foreach ($status as $key=>$value) { ?>
                <div class="form-check form-check-inline">
                  <input type="radio" name="gsite_status" id="gsite_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($gsiteRow['gsite_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                  <label for="gsite_status_<?php echo $value; ?>" class="form-check-label">
                    <?php echo $lang->get($value); ?>
                  </label>
                </div>
              <?php } ?>
            </div>
            <small class="form-text" id="msg_gsite_status"></small>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
