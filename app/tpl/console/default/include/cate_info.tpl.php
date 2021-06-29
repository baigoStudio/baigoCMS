<div class="form-group">
    <label><?php echo $lang->get('ID'); ?></label>
    <div class="form-text"><?php echo $cateRow['cate_id']; ?></div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Status'); ?></label>
    <div class="form-text">
        <?php $str_status = $cateRow['cate_status'];
        include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?>
    </div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Parent category'); ?></label>
    <div class="form-text"><?php if (isset($cateParent['cate_name'])) {
        echo $cateParent['cate_name'];
    } else {
        echo $lang->get('As a primary category');
    } ?></div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Template'); ?></label>
    <div class="form-text">
        <?php if ($cateRow['cate_tpl'] == '-1') {
            echo $lang->get('Inherit');
        } else {
            echo $cateRow['cate_tpl'];
        } ?>
    </div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Cover'); ?></label>
    <div class="mb-2">
        <?php if (isset($attachRow['attach_thumb']) && !empty($attachRow['attach_thumb'])) { ?>
            <img src="<?php echo $attachRow['attach_thumb']; ?>" class="img-fluid">
        <?php } ?>
    </div>

    <div class="form-text"><?php if (isset($attachRow['attach_thumb'])) { echo $attachRow['attach_thumb']; } ?></div>
</div>
