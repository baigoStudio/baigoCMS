<div class="form-group">
    <label><?php echo $lang->get('ID'); ?></label>
    <div class="form-text"><?php echo $specRow['spec_id']; ?></div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Status'); ?></label>
    <div class="form-text"><?php $str_status = $specRow['spec_status'];
    include($cfg['pathInclude'] . 'status_process' . GK_EXT_TPL); ?></div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Time'); ?></label>
    <div class="form-text"><?php echo $specRow['spec_time_format']['date_time']; ?></div>
</div>

<div class="form-group">
    <label><?php echo $lang->get('Updated time'); ?></label>
    <div class="form-text"><?php echo $specRow['spec_time_update_format']['date_time']; ?></div>
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
