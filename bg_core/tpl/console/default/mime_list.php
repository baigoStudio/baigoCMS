<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['mime'],
    'menu_active'    => 'attach',
    'sub_active'     => 'mime',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=mime&act=list"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=mime&act=form">
                    <span class="glyphicon glyphicon-plus"></span>
                    <?php echo $this->lang['mod']['href']['add']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=attach#mime" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="mime_list" id="mime_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                            <th><?php echo $this->lang['mod']['label']['note']; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['ext']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData['mimeRows'] as $key=>$value) { ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="mime_ids[]" value="<?php echo $value['mime_id']; ?>" id="mime_id_<?php echo $value['mime_id']; ?>" data-parent="chk_all" data-validate="mime_id"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value['mime_id']; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><?php echo $value['mime_note']; ?></li>
                                        <li>
                                            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=mime&act=form&mime_id=<?php echo $value['mime_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <?php echo $value['mime_ext']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_mime_id"></span></td>
                            <td colspan="2">
                                <div class="bg-submit-box bg-submit-box-list"></div>
                                <input type="hidden" name="act" id="act" value="del">
                                <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['del']; ?></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </form>

    <div class="text-right">
        <?php include($cfg['pathInclude'] . 'page.php'); ?>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        mime_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='mime_id']", type: "checkbox" },
            msg: { selector: "#msg_mime_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=mime",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_list   = $("#mime_list").baigoValidator(opts_validator_list);
        var obj_submit_list     = $("#mime_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#mime_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>