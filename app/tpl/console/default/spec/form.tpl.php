<?php if ($specRow['spec_id'] > 0) {
    $title_sub    = $lang->get('Edit');
    $str_sub      = 'index';
} else {
    $title_sub    = $lang->get('Add');
    $str_sub      = 'form';
}

$cfg = array(
    'title'             => $lang->get('Special topic', 'console.common') . ' &raquo; ' . $title_sub,
    'menu_active'       => 'spec',
    'sub_active'        => $str_sub,
    'baigoValidate'     => 'true',
    'baigoSubmit'       => 'true',
    'tinymce'           => 'true',
    'upload'            => 'true',
    'datetimepicker'    => 'true',
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'console_head' . GK_EXT_TPL); ?>

    <nav class="nav mb-3">
        <a href="<?php echo $route_console; ?>spec/" class="nav-link">
            <span class="fas fa-chevron-left"></span>
            <?php echo $lang->get('Back'); ?>
        </a>
    </nav>

    <form name="spec_form" id="spec_form" action="<?php echo $route_console; ?>spec/submit/">
        <input type="hidden" name="__token__" value="<?php echo $token; ?>">
        <input type="hidden" name="spec_id" id="spec_id" value="<?php echo $specRow['spec_id']; ?>">

        <div class="row">
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $lang->get('Name'); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="spec_name" id="spec_name" value="<?php echo $specRow['spec_name']; ?>" class="form-control">
                            <small class="form-text" id="msg_spec_name"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Content'); ?></label>
                            <div class="mb-2">
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-outline-success" data-toggle="modal" href="#spec_modal" data-act="attach">
                                        <span class="fas fa-photo-video"></span>
                                        <?php echo $lang->get('Add media'); ?>
                                    </a>
                                    <a class="btn btn-outline-secondary" data-toggle="modal" href="#spec_modal" data-act="album">
                                        <span class="fas fa-images"></span>
                                        <?php echo $lang->get('Add album'); ?>
                                    </a>
                                    <?php if ($specRow['spec_id'] > 0) { ?>
                                        <a href="<?php echo $route_console; ?>spec/attach/id/<?php echo $specRow['spec_id']; ?>/" class="btn btn-outline-secondary">
                                            <?php echo $lang->get('Cover management'); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <textarea type="text" name="spec_content" id="spec_content" class="form-control tinymce"><?php echo $specRow['spec_content']; ?></textarea>
                            <small class="form-text" id="msg_spec_content"></small>
                        </div>

                        <div class="bg-validate-box"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <?php if ($specRow['spec_id'] > 0) { ?>
                            <div class="form-group">
                                <label><?php echo $lang->get('ID'); ?></label>
                                <input type="text" value="<?php echo $specRow['spec_id']; ?>" class="form-control-plaintext" readonly>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label><?php echo $lang->get('Status'); ?> <span class="text-danger">*</span></label>
                            <?php foreach ($status as $key=>$value) { ?>
                                <div class="form-check">
                                    <input type="radio" name="spec_status" id="spec_status_<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($specRow['spec_status'] == $value) { ?>checked<?php } ?> class="form-check-input">
                                    <label for="spec_status_<?php echo $value; ?>" class="form-check-label">
                                        <?php echo $lang->get($value); ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <small class="form-text" id="msg_spec_status"></small>
                        </div>

                        <div class="form-group">
                            <label><?php echo $lang->get('Updated time'); ?></label>
                            <input type="text" name="spec_time_update_format" id="spec_time_update_format" value="<?php echo $specRow['spec_time_update_format']['date_time']; ?>" class="form-control input_date">
                            <small class="form-text" id="msg_spec_time_update_format"></small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $lang->get('Save'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="spec_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot' . GK_EXT_TPL); ?>

    <script type="text/javascript">
    var opts_validate_form = {
        rules: {
            spec_name: {
                length: '1,300'
            },
            spec_content: {
                max: 3000
            },
            spec_status: {
                require: true
            },
            spec_time_update_format: {
                format: 'date_time'
            }
        },
        attr_names: {
            spec_name: '<?php echo $lang->get('Name'); ?>',
            spec_content: '<?php echo $lang->get('Content'); ?>',
            spec_status: '<?php echo $lang->get('Status'); ?>',
            spec_time_update_format: '<?php echo $lang->get('Updated time'); ?>'
        },
        type_msg: {
            require: '<?php echo $lang->get('{:attr} require'); ?>',
            max: '<?php echo $lang->get('Max size of {:attr} must be {:rule}'); ?>',
            length: '<?php echo $lang->get('Size of {:attr} must be {:rule}'); ?>',
            checkbox: '<?php echo $lang->get('Choose at least one {:attr}'); ?>'
        },
        format_msg: {
            date_time: '<?php echo $lang->get('{:attr} not a valid datetime'); ?>'
        },
        msg: {
            loading: '<?php echo $lang->get('Loading'); ?>'
        },
        box: {
            msg: '<?php echo $lang->get('Input error'); ?>'
        }
    };

    var opts_submit_form = {
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
        $('#spec_modal').on('shown.bs.modal', function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _act          = _obj_button.data('act');

    		switch (_act) {
        		case 'album':
            		var _url  = '<?php echo $route_console; ?>album/choose/view/modal/';
        		break;

        		default:
            		var _url  = '<?php echo $route_console; ?>attach/choose/view/modal/';
        		break;
            }

            $('#spec_modal .modal-content').load(_url);
    	}).on('hidden.bs.modal', function(){
        	$('#spec_modal .modal-content').empty();
    	});

        var obj_validate_form  = $('#spec_form').baigoValidate(opts_validate_form);
        var obj_submit_form     = $('#spec_form').baigoSubmit(opts_submit_form);

        $('#spec_form').submit(function(){
            if (obj_validate_form.verify()) {
                tinyMCE.triggerSave();
                obj_submit_form.formSubmit();
            }
        });

        $('.input_date').datetimepicker(opts_datetimepicker);
    });
    </script>
<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);