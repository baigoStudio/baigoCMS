  <div class="form-group">
    <label><?php echo $lang->get('Add on album'); ?></label>
    <div id="album_list" class="mb-3">
      <?php foreach ($albumRows as $key=>$value) { ?>
        <div class="input-group mb-2" id="album_item_<?php echo $value['album_id']; ?>">
          <div class="input-group-prepend">
            <div class="input-group-text border-success">
              <input type="hidden" name="attach_album_ids[]" class="attach_album_ids" value="<?php echo $value['album_id']; ?>">
              <span class="bg-icon text-primary"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>
            </div>
          </div>
          <input type="text" class="form-control border-success bg-transparent" readonly value="<?php echo $value['album_name']; ?>">
          <div class="input-group-append">
            <button type="button" class="btn btn-success album_del" data-id="<?php echo $value['album_id']; ?>">
              <span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>
            </button>
          </div>
        </div>
      <?php } ?>
    </div>
    <input type="text" id="album_key" name="album_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
  </div>
