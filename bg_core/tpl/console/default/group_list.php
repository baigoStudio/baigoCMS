<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['group']['main']['title'],
    'menu_active'    => 'group',
    'sub_active'     => "list",
    'baigoCheckall'  => 'true',
    'baigoValidator' => 'true',
    'baigoSubmit'    => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    'str_url'        => BG_URL_CONSOLE . "index.php?mod=group&act=list&" . $this->tplData['query'],
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li>
                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=form">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang['mod']['href']['add']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=group" target="_blank">
                            <span class="glyphicon glyphicon-question-sign"></span>
                            <?php echo $this->lang['mod']['href']['help']; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pull-right">
            <form name="group_search" id="group_search" action="<?php echo BG_URL_CONSOLE; ?>index.php" method="get" class="form-inline">
                <input type="hidden" name="mod" value="group">
                <input type="hidden" name="act" value="list">
                <div class="form-group hidden-sm hidden-xs">
                    <select name="type" class="form-control input-sm">
                        <option value=""><?php echo $this->lang['mod']['option']['allType']; ?></option>
                        <?php foreach ($this->tplData['type'] as $key=>$value) { ?>
                            <option <?php if ($this->tplData['search']['type'] == $value) { ?>selected<?php } ?> value="<?php echo $value; ?>">
                                <?php if (isset($this->lang['mod']['type'][$value])) {
                                    echo $this->lang['mod']['type'][$value];
                                } else {
                                    echo $value;
                                } ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <input type="text" name="key" class="form-control" value="<?php echo $this->tplData['search']['key']; ?>" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form name="group_list" id="group_list" class="form-inline">
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
                            <th><?php echo $this->lang['mod']['label']['group']; ?></th>
                            <th class="text-nowrap bg-td-md"><?php echo $this->lang['mod']['label']['type']; ?> / <?php echo $this->lang['mod']['label']['note']; ?></th>
                            <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['status']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData['groupRows'] as $key=>$value) { ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="group_ids[]" value="<?php echo $value['group_id']; ?>" id="group_id_<?php echo $value['group_id']; ?>" data-parent="chk_all" data-validate="group_id"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value['group_id']; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><?php echo $value['group_name']; ?></li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=show&group_id=<?php echo $value['group_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=group&act=form&group_id=<?php echo $value['group_id']; ?>"><?php echo $this->lang['mod']['href']['edit']; ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-md">
                                    <ul class="list-unstyled">
                                        <li>
                                            <?php if (isset($this->lang['mod']['type'][$value['group_type']])) {
                                                echo $this->lang['mod']['type'][$value['group_type']];
                                            } ?>
                                        </li>
                                        <li><?php echo $value['group_note']; ?></li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-sm">
                                    <?php group_status_process($value['group_status'], $this->lang['mod']['status']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_group_id"></span></td>
                            <td colspan="3">
                                <div class="bg-submit-box"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang['mod']['option']['batch']; ?></option>
                                            <?php foreach ($this->tplData['status'] as $key=>$value) { ?>
                                                <option value="<?php echo $value; ?>">
                                                    <?php if (isset($this->lang['mod']['status'][$value])) {
                                                        echo $this->lang['mod']['status'][$value];
                                                    } else {
                                                        echo $value;
                                                    } ?>
                                                </option>
                                            <?php } ?>
                                            <option value="del"><?php echo $this->lang['mod']['option']['del']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang['mod']['btn']['submit']; ?></button>
                                </div>
                                <div class="form-group">
                                    <span id="msg_act"></span>
                                </div>
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
        group_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='group_id']", type: "checkbox" },
            msg: { selector: "#msg_group_id", too_few: "<?php echo $this->lang['rcode']['x030202']; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->lang['rcode']['x030203']; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=group",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang['mod']['confirm']['del']; ?>"
        },
        msg_text: {
            submitting: "<?php echo $this->lang['common']['label']['submitting']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_validate_list = $("#group_list").baigoValidator(opts_validator_list);
        var obj_submit_list = $("#group_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#group_list").baigoCheckall();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>