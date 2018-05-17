<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "prism"          => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php');
include($cfg['pathInclude'] . 'gsite_head.php'); ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="a" value="stepPageList">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <?php include($cfg['pathInclude'] . 'gsite_menu.php'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['selectorPageList']; ?> <span class="text-danger">*</span></label>
                            <input type="text" name="gsite_page_list_selector" id="gsite_page_list_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_page_list_selector']; ?>" data-validate class="form-control">
                            <small class="form-text" id="msg_gsite_page_list_selector"></small>
                            <small class="form-text"><?php echo $this->lang['mod']['label']['selectorListNote']; ?></small>
                        </div>

                        <div class="bg-submit-box"></div>
                        <div class="bg-validator-box mt-3"></div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><?php echo $this->lang['mod']['label']['previewPage']; ?></div>
                    <div class="card-body" id="gsite_preview">
                        <div class="loading">
                            <h1>
                                <span class="oi oi-loop-circular bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                    <div class="card-body" id="gsite_source">
                        <div class="loading">
                            <h1>
                                <span class="oi oi-loop-circular bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <?php include($cfg['pathInclude'] . 'gsite_side.php'); ?>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'gsite_foot.php');
include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_form = {
        gsite_page_list_selector: {
            len: { min: 1, max: 100 },
            validate: { type: "str", format: "text" },
            msg: { too_short: "<?php echo $this->lang['rcode']['x270216']; ?>", too_long: "<?php echo $this->lang['rcode']['x270217']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&c=request",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    var options_validator_form = {
        msg_global:{
            msg: "<?php echo $this->lang['common']['label']['errInput']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form, options_validator_form);
        var obj_submit_form   = $("#gsite_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $("#gsite_preview").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite_preview&a=pageList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");

        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite_source&a=content&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include('include' . DS . 'html_foot.php');