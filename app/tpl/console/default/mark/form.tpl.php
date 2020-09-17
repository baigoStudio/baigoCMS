    <?php if ($markRow['mark_id'] > 0) {
        $title_sub    = $lang->get('Edit');
    } else {
        $title_sub    = $lang->get('Add');
    } ?>

    <form name="mark_form" id="mark_form" action="<?php echo $route_console; ?>mark/submit/">
        <input type="hidden" name="<?php echo $token['name']; ?>" value="<?php echo $token['value']; ?>">
        <input type="hidden" name="mark_id" id="mark_id" value="<?php echo $markRow['mark_id']; ?>">

        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Mark', 'console.common'), ' &raquo; ', $title_sub; ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <?php if ($markRow['mark_id'] > 0) { ?>
                <div class="form-group">
                    <label><?php echo $lang->get('ID'); ?></label>
                    <input type="text" value="<?php echo $markRow['mark_id']; ?>" class="form-control-plaintext" readonly>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                <input value="<?php echo $markRow['mark_name']; ?>" name="mark_name" id="mark_name" class="form-control">
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
            mark_name: {
                length: '1,30'
            }
        },
        attr_names: {
            mark_name: '<?php echo $lang->get('Name'); ?>'
        },
        type_msg: {
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>'
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
        var obj_validate_modal   = $('#mark_form').baigoValidate(opts_validate_modal);
        var obj_submit_modal     = $('#mark_form').baigoSubmit(opts_submit_modal);

        $('#mark_form').submit(function(){
            if (obj_validate_modal.verify()) {
                obj_submit_modal.formSubmit();
            }
        });
    });
    </script>