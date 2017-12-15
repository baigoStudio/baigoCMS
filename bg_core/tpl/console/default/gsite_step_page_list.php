<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    "prism"          => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=gsite",
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=gsite#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <?php if ($this->tplData['gsiteRow']['gsite_id'] > 0) {
        include($cfg['pathInclude'] . "gsite_menu.php");
    } ?>

    <form name="gsite_form" id="gsite_form">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="act" value="stepPageList">
        <input type="hidden" name="gsite_id" id="gsite_id" value="<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div id="group_gsite_page_list_selector">
                                <label class="control-label"><?php echo $this->lang['mod']['label']['selectorPageList']; ?><span id="msg_gsite_page_list_selector">*</span></label>
                                <input type="text" name="gsite_page_list_selector" id="gsite_page_list_selector" value="<?php echo $this->tplData['gsiteRow']['gsite_page_list_selector']; ?>" data-validate class="form-control">
                                <span class="help-block"><?php echo $this->lang['mod']['label']['selectorListNote']; ?></span>
                            </div>
                        </div>

                        <div class="bg-submit-box"></div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['save']; ?></button>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $this->lang['mod']['label']['previewPage']; ?></div>
                    <div class="panel-body" id="gsite_preview">
                        <div class="loading">
                            <h1>
                                <span class="glyphicon glyphicon-refresh bg-spin"></span>
                                Loading...
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $this->lang['mod']['label']['gsiteSource']; ?></div>
                    <div class="panel-body" id="gsite_source">
                        <div class="loading">
                            <h1>
                                <span class="glyphicon glyphicon-refresh bg-spin"></span>
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
            validate: { type: "str", format: "text", group: "#group_gsite_page_list_selector" },
            msg: { selector: "#msg_gsite_page_list_selector", too_short: "<?php echo $this->lang['rcode']['x270216']; ?>", too_long: "<?php echo $this->lang['rcode']['x270217']; ?>" }
        }
    };

    var opts_submit_form = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gsite",
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_form = $("#gsite_form").baigoValidator(opts_validator_form);
        var obj_submit_form   = $("#gsite_form").baigoSubmit(opts_submit_form);
        $(".bg-submit").click(function(){
            if (obj_validate_form.verify()) {
                obj_submit_form.formSubmit();
            }
        });

        $("#gsite_preview").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite_preview&act=pageList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");

        $("#gsite_source").html("<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' scrolling='auto' src='<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite_source&act=content&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>'></iframe></div>");
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>