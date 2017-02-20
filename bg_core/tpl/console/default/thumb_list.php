<?php $cfg = array(
    "title"          => $this->consoleMod["attach"]["main"]["title"] . " &raquo; " . $this->consoleMod["attach"]["sub"]["thumb"]["title"],
    "menu_active"    => "attach",
    "sub_active"     => "thumb",
    "baigoCheckall"  => "true",
    "baigoValidator" => "true",
    "baigoSubmit"    => "true",
    "baigoClear"     => "true",
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
    "str_url"        => BG_URL_CONSOLE . "index.php?mod=thumb&act=list"
);

include($cfg["pathInclude"] . "console_head.php"); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="#thumb_modal" data-toggle="modal" data-id="0">
                    <span class="glyphicon glyphicon-plus"></span>
                    <?php echo $this->lang["href"]["add"]; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=attach#thumb" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang["href"]["help"]; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="thumb_list" id="thumb_list" class="form-inline">
        <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">

        <div class="panel panel-default">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap bg-td-xs">
                                <label for="chk_all" class="checkbox-inline">
                                    <input type="checkbox" name="chk_all" id="chk_all" data-parent="first">
                                    <?php echo $this->lang["label"]["all"]; ?>
                                </label>
                            </th>
                            <th class="text-nowrap bg-td-xs"><?php echo $this->lang["label"]["id"]; ?></th>
                            <th><?php echo $this->lang["label"]["thumbWidth"]; ?> X <?php echo $this->lang["label"]["thumbHeight"]; ?></th>
                            <th class="text-nowrap bg-td-lg"><?php echo $this->lang["label"]["thumbCall"]; ?></th>
                            <th class="text-nowrap bg-td-sm"><?php echo $this->lang["label"]["thumbType"]; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->tplData["thumbRows"] as $key=>$value) { ?>
                            <tr>
                                <td class="text-nowrap bg-td-xs"><input type="checkbox" name="thumb_ids[]" value="<?php echo $value["thumb_id"]; ?>" id="thumb_id_<?php echo $value["thumb_id"]; ?>" data-validate="thumb_id" data-parent="chk_all"></td>
                                <td class="text-nowrap bg-td-xs"><?php echo $value["thumb_id"]; ?></td>
                                <td>
                                    <ul class="list-unstyled">
                                        <li><?php echo $value["thumb_width"]; ?> X <?php echo $value["thumb_height"]; ?></li>
                                        <li>
                                            <ul class="bg-nav-line">
                                                <?php if ($value["thumb_id"] > 0) { ?>
                                                    <li>
                                                        <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=thumb&act=show&thumb_id=<?php echo $value["thumb_id"]; ?>"><?php echo $this->lang["href"]["show"]; ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="#thumb_modal" data-toggle="modal" data-id="<?php echo $value["thumb_id"]; ?>"><?php echo $this->lang["href"]["edit"]; ?></a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>
                                                        <?php echo $this->lang["href"]["show"]; ?>
                                                    </li>
                                                    <li>
                                                        <?php echo $this->lang["href"]["edit"]; ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-nowrap bg-td-lg">thumb_<?php echo $value["thumb_width"]; ?>_<?php echo $value["thumb_height"]; ?>_<?php echo $value["thumb_type"]; ?></td>
                                <td class="text-nowrap bg-td-sm"><?php echo $this->type["thumb"][$value["thumb_type"]]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><span id="msg_thumb_id"></span></td>
                            <td colspan="3">
                                <div class="bg-submit-box bg-submit-box-list"></div>
                                <div class="form-group">
                                    <div id="group_act">
                                        <select name="act" id="act" data-validate class="form-control input-sm">
                                            <option value=""><?php echo $this->lang["option"]["batch"]; ?></option>
                                            <option value="cache"><?php echo $this->lang["option"]["cache"]; ?></option>
                                            <option value="del"><?php echo $this->lang["option"]["del"]; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-sm bg-submit"><?php echo $this->lang["btn"]["submit"]; ?></button>
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
        <?php include($cfg["pathInclude"] . "page.php"); ?>
    </div>

    <div class="modal fade" id="thumb_modal">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

<?php include($cfg["pathInclude"] . "console_foot.php"); ?>

    <script type="text/javascript">
    var opts_validator_list = {
        thumb_id: {
            len: { min: 1, max: 0 },
            validate: { selector: "[data-validate='thumb_id']", type: "checkbox" },
            msg: { selector: "#msg_thumb_id", too_few: "<?php echo $this->rcode["x030202"]; ?>" }
        },
        act: {
            len: { min: 1, max: 0 },
            validate: { type: "select", group: "#group_act" },
            msg: { selector: "#msg_act", too_few: "<?php echo $this->rcode["x030203"]; ?>" }
        }
    };

    var opts_submit_list = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=thumb",
        confirm: {
            selector: "#act",
            val: "del",
            msg: "<?php echo $this->lang["confirm"]["del"]; ?>"
        },
        box: {
            selector: ".bg-submit-box-list"
        },
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        }
    };

    $(document).ready(function(){
        $("#thumb_modal").on("shown.bs.modal", function(event) {
    		var _obj_button   = $(event.relatedTarget);
    		var _id           = _obj_button.data("id");
            $("#thumb_modal .modal-content").load("<?php echo BG_URL_CONSOLE; ?>index.php?mod=thumb&act=form&thumb_id=" + _id + "&view=iframe");
        });
        var obj_validate_list = $("#thumb_list").baigoValidator(opts_validator_list);
        var obj_submit_list   = $("#thumb_list").baigoSubmit(opts_submit_list);
        $(".bg-submit").click(function(){
            if (obj_validate_list.verify()) {
                obj_submit_list.formSubmit();
            }
        });
        $("#thumb_list").baigoCheckall();
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>