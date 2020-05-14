
    <form name="admin_addon_form" id="admin_addon_form" action="<?php echo $route_console; ?>admin/addon-submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $adminRow['admin_id']; ?>">

        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Administrator', 'console.common'), ' &raquo; ', $lang->get('Add on group'); ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label><?php echo $lang->get('ID'); ?></label>
                <input type="text" value="<?php echo $adminRow['admin_id']; ?>" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Username'); ?></label>
                <input type="text" value="<?php echo $adminRow['admin_name']; ?>" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Add on group'); ?> <span class="text-danger">*</span></label>
                <select name="admin_group_id" id="admin_group_id" class="form-control">
                    <option value=""><?php echo $lang->get('Please select'); ?></option>
                    <option <?php if ($adminRow['admin_group_id'] == 0) { ?>selected<?php } ?> value="0"><?php echo $lang->get('Do not addon group'); ?></option>
                    <?php foreach ($groupRows as $key=>$value) { ?>
                        <option <?php if ($adminRow['admin_group_id'] == $value['group_id']) { ?>selected<?php } ?> value="<?php echo $value['group_id']; ?>"><?php echo $value['group_name']; ?></option>
                    <?php } ?>
                </select>
                <small class="form-text" id="msg_group_id"></small>
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
            admin_group_id: {
                require: true
            }
        },
        attr_names: {
            admin_group_id: '<?php echo $lang->get('Group'); ?>'
        },
        type_msg: {
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
        var obj_validate_modal   = $('#admin_addon_form').baigoValidate(opts_validate_modal);
        var obj_submit_modal     = $('#admin_addon_form').baigoSubmit(opts_submit_modal);

        $('#admin_addon_form').submit(function(){
            if (obj_validate_modal.verify()) {
                obj_submit_modal.formSubmit();
            }
        });
    });
    </script>