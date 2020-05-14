    <?php if ($tagRow['tag_id'] > 0) {
        $title_sub    = $lang->get('Edit');
    } else {
        $title_sub    = $lang->get('Add');
    } ?>

    <form name="tag_form" id="tag_form" action="<?php echo $route_console; ?>tag/submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $tagRow['tag_id']; ?>">

        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Tag', 'console.common'), ' &raquo; ', $title_sub; ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <?php if ($tagRow['tag_id'] > 0) { ?>
                <div class="form-group">
                    <label><?php echo $lang->get('ID'); ?></label>
                    <input type="text" value="<?php echo $tagRow['tag_id']; ?>" class="form-control-plaintext" readonly>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                <input value="<?php echo $tagRow['tag_name']; ?>" name="tag_name" id="tag_name" class="form-control">
                <small class="form-text" id="msg_tag_name"></small>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                <div>
                    <?php foreach ($status as $key=>$value) { ?>
                        <div class="form-check-inline">
                            <input type="radio" name="tag_status" id="tag_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($tagRow['tag_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                            <label for="tag_status_<?php echo $value; ?>" class="form-check-label">
                                <?php echo $lang->get($value); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <small class="form-text" id="msg_tag_status"></small>
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
            tag_name: {
                length: '1,30'
            },
            tag_status: {
                require: true
            }
        },
        attr_names: {
            tag_name: '<?php echo $lang->get('Name'); ?>',
            tag_status: '<?php echo $lang->get('Status'); ?>'
        },
        type_msg: {
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            require: '<?php echo $lang->get('{:attr} require'); ?>'
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
        var obj_validate_modal   = $('#tag_form').baigoValidate(opts_validate_modal);
        var obj_submit_modal     = $('#tag_form').baigoSubmit(opts_submit_modal);

        $('#tag_form').submit(function(){
            if (obj_validate_modal.verify()) {
                obj_submit_modal.formSubmit();
            }
        });
    });
    </script>