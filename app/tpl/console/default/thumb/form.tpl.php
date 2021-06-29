    <?php if ($thumbRow['thumb_id'] > 0) {
        $title_sub    = $lang->get('Edit');
    } else {
        $title_sub    = $lang->get('Add');
    } ?>

    <form name="thumb_form" id="thumb_form" action="<?php echo $route_console; ?>thumb/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="thumb_id" id="thumb_id" value="<?php echo $thumbRow['thumb_id']; ?>">

        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Thumbnails', 'console.common'), ' &raquo; ', $title_sub; ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <?php if ($thumbRow['thumb_id'] > 0) { ?>
                <div class="form-group">
                    <label><?php echo $lang->get('ID'); ?></label>
                    <input type="text" value="<?php echo $thumbRow['thumb_id']; ?>" class="form-control-plaintext" readonly>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?php echo $lang->get('Maximum width'); ?> <span class="text-danger">*</span></label>
                <input value="<?php echo $thumbRow['thumb_width']; ?>" name="thumb_width" id="thumb_width" class="form-control">
                <small class="form-text" id="msg_thumb_width"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Maximum height'); ?> <span class="text-danger">*</span></label>
                <input value="<?php echo $thumbRow['thumb_height']; ?>" name="thumb_height" id="thumb_height" class="form-control">
                <small class="form-text" id="msg_thumb_height"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Quality'); ?> <span class="text-danger">*</span></label>
                <input value="<?php echo $thumbRow['thumb_quality']; ?>" name="thumb_quality" id="thumb_quality" class="form-control">
                <small class="form-text" id="msg_thumb_quality">
                    <?php echo $lang->get('0 - 100, only valid for JPG and PNG'); ?>
                </small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Type'); ?> <span class="text-danger">*</span></label>
                <div>
                    <?php foreach ($type as $key=>$value) { ?>
                        <div class="form-check-inline">
                            <input type="radio" name="thumb_type" id="thumb_type_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($thumbRow['thumb_type'] == $value) { ?>checked<?php } ?> class="form-check-input">
                            <label for="thumb_type_<?php echo $value; ?>" class="form-check-label">
                                <?php echo $lang->get($value); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <small class="form-text" id="msg_thumb_type"></small>
            </div>

            <div class="bg-validate-box"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <?php echo $lang->get('Save'); ?>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                <?php echo $lang->get('Close', 'console.common'); ?>
            </button>
        </div>
    </form>

    <script type="text/javascript">
    var opts_validate_modal = {
        rules: {
            thumb_width: {
                require: true,
                format: 'int'
            },
            thumb_height: {
                require: true,
                format: 'int'
            },
            thumb_quality: {
                between: '1,100',
                format: 'int'
            },
            thumb_type: {
                require: true
            }
        },
        attr_names: {
            thumb_width: '<?php echo $lang->get('Maximum width'); ?>',
            thumb_height: '<?php echo $lang->get('Maximum height'); ?>',
            thumb_quality: '<?php echo $lang->get('Quality'); ?>',
            thumb_type: '<?php echo $lang->get('Type'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            between: '<?php echo $lang->get('{:attr} must between {:rule}'); ?>'
        },
        format_msg: {
            'int': '<?php echo $lang->get('{:attr} must be integer'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
        }
    };

    var opts_submit_modal = {
        modal: {
            btn_text: {
                close: '<?php echo $lang->get('Close'); ?>',
                ok: '<?php echo $lang->get('OK'); ?>'
            }
        },
        msg_text: {
            submitting: '<?php echo $lang->get('Saving'); ?>'
        }
    };

    $(document).ready(function(){
        var obj_validate_modal   = $('#thumb_form').baigoValidate(opts_validate_modal);
        var obj_submit_modal     = $('#thumb_form').baigoSubmit(opts_submit_modal);

        $('#thumb_form').submit(function(){
            if (obj_validate_modal.verify()) {
                obj_submit_modal.formSubmit();
            }
        });
    });
    </script>
