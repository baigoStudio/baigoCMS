<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['mime'],
    'menu_active'    => 'attach',
    'sub_active'     => 'mime',
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?m=mime&a=list"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&a=form" class="nav-link">
                <span class="oi oi-plus"></span>
                <?php echo $this->lang['mod']['href']['add']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=attach#mime" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="mime_list" id="mime_list">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">

        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead>
                    <tr>
                        <th class="text-nowrap bg-td-xs">
                            <div class="form-check">
                                <label for="chk_all" class="form-check-label">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first" class="form-check-input">
                                    <?php echo $this->lang['mod']['label']['all']; ?>
                                </label>
                            </div>
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
                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&a=form&mime_id=<?php echo $value['mime_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-nowrap bg-td-md">
                                <?php echo $value['mime_ext']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

       <div class="mt-3">
            <small class="form-text" id="msg_mime_id"></small>
            <div class="bg-submit-box bg-submit-box-list"></div>
        </div>

        <div class="clearfix mt-3">
            <div class="float-left">
                <input type="hidden" name="a" id="a" value="del">
                <button type="button" class="btn btn-primary bg-submit"><?php echo $this->lang['mod']['btn']['del']; ?></button>
            </div>
            <div class="float-right">
                <?php include($cfg['pathInclude'] . 'page.php'); ?>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        mime_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='mime_id']", type: "checkbox" },
            msg: { too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=mime&c=request",
        confirm: {
            selector: "#a",
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

<?php include('include' . DS . 'html_foot.php');