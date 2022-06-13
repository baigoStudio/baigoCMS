
  <div class="form-group">
    <label>
      <?php echo $lang->get($value['title']), $lang->get('Selector'); ?>
      <?php if (isset($value['require'])) { ?><span class="text-danger">*</span><?php } ?>
    </label>
    <input type="text" name="gsite_<?php echo $key; ?>_selector" id="gsite_<?php echo $key; ?>_selector" value="<?php echo $gsiteRow['gsite_' . $key . '_selector']; ?>" class="form-control">
    <small class="form-text" id="msg_gsite_<?php echo $key; ?>_selector"><?php echo $lang->get('Please use the jQuery selector'); ?></small>
  </div>

  <div class="form-group">
    <label><?php echo $lang->get('Gathering attribute'); ?></label>
    <div class="input-group">
      <span class="input-group-prepend">
        <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-href="<?php echo $hrefRow['gsite-help']; ?>attr_qlist">
          <span class="bg-icon"><?php include($tpl_icon . 'question-circle' . BG_EXT_SVG); ?></span>
        </a>
      </span>
      <input type="text" name="gsite_<?php echo $key; ?>_attr" id="gsite_<?php echo $key; ?>_attr" value="<?php echo $gsiteRow['gsite_' . $key . '_attr']; ?>" class="form-control">
      <span class="input-group-append">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
          <?php echo $lang->get('Common attribute'); ?>
        </button>

        <div class="dropdown-menu">
          <?php foreach ($attrOften as $_key=>$_value) { ?>
            <button class="dropdown-item bg-select-input" data-value="<?php echo $_key; ?>" data-target="#gsite_<?php echo $key; ?>_attr" type="button">
                <?php echo $_key; ?>
              -
              <?php echo $lang->get($_value); ?>
            </button>
          <?php } ?>
        </div>
      </span>
    </div>
    <small class="form-text" id="msg_gsite_<?php echo $key; ?>_attr"><?php echo $lang->get('Default is html'); ?></small>
  </div>

  <div class="form-group">
    <label><?php echo $lang->get('Filter'); ?></label>
    <div class="input-group">
      <span class="input-group-prepend">
        <a href="#help_modal" class="btn btn-warning" data-toggle="modal" data-href="<?php echo $hrefRow['gsite-help']; ?>filter">
          <span class="bg-icon"><?php include($tpl_icon . 'question-circle' . BG_EXT_SVG); ?></span>
        </a>
      </span>
      <input type="text" name="gsite_<?php echo $key; ?>_filter" id="gsite_<?php echo $key; ?>_filter" value="<?php echo $gsiteRow['gsite_' . $key . '_filter']; ?>" class="form-control">
    </div>
    <small class="form-text" id="msg_gsite_<?php echo $key; ?>_filter"><?php echo $lang->get('Filter out unwanted elements, and multiple values separated by <kbd>,</kbd>'); ?></small>
  </div>

  <label><?php echo $lang->get('Replace'); ?></label>

  <div id="<?php echo $key; ?>_replace" class="replace_box">
    <?php foreach ($gsiteRow['gsite_' . $key . '_replace'] as $key_replace=>$value_replace) { ?>
      <div id="<?php echo $key; ?>_replace_group_<?php echo $key_replace; ?>" class="form-row" data-count="<?php echo $key_replace; ?>">
        <div class="form-group col-lg-6">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><?php echo $lang->get('Search'); ?></span>
            </div>
            <input type="text" name="gsite_<?php echo $key; ?>_replace[<?php echo $key_replace; ?>][search]" id="gsite_<?php echo $key; ?>_replace_<?php echo $key_replace; ?>_search" value="<?php echo $value_replace['search']; ?>" class="form-control">
          </div>
        </div>
        <div class="form-group col-lg-6">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><?php echo $lang->get('Replace'); ?></span>
            </div>
            <input type="text" name="gsite_<?php echo $key; ?>_replace[<?php echo $key_replace; ?>][replace]" id="gsite_<?php echo $key; ?>_replace_<?php echo $key_replace; ?>_replace" value="<?php echo $value_replace['replace']; ?>" class="form-control">
            <span class="input-group-append">
              <button type="button" data-count="<?php echo $key_replace; ?>" data-type="<?php echo $key; ?>" class="btn btn-info replace_del">
                <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
              </button>
            </span>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="form-group">
    <button type="button" data-type="<?php echo $key; ?>" class="btn btn-info replace_add">
      <span class="bg-icon"><?php include($tpl_icon . 'plus' . BG_EXT_SVG); ?></span>
    </button>
  </div>

  <small class="form-text"><?php echo $lang->get('If "Replace" is empty, system will remove the character, the usage is similar to the search and replace of Word, WPS'); ?></small>
