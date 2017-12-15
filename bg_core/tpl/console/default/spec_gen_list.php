<?php $cfg = array(
    'title'         => $this->lang['common']['page']['gening'],
    'noToken'       => 'true',
    'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

$_rcode = "y120406";

include($cfg['pathInclude'] . 'html_head.php'); ?>
    <style type="text/css">
    body {
        padding: 0 15px;
    }
    </style>

    <div class="alert alert-success">
        <h3>
            <span class="glyphicon glyphicon-ok-sign"></span>
            <?php if (isset($this->lang['rcode'][$_rcode])) {
                echo $this->lang['rcode'][$_rcode];
            } ?>
        </h3>
        <div>
            <?php echo $this->lang['common']['page']['rcode'], ' ', $_rcode; ?>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th><?php echo $this->lang['common']['label']['spec']; ?> / <?php echo $this->lang['mod']['label']['pageNo']; ?></th>
                <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
                <tr id="spec_<?php echo $_iii; ?>_tr" class="text-info">
                    <td>
                        <h5>
                            <?php echo $this->lang['common']['label']['spec']; ?>
                        </h5>
                        <div>
                            <?php echo $this->lang['mod']['label']['pageCount']; ?>
                            <?php echo $_iii; ?>
                            <?php echo $this->lang['mod']['label']['pagePage']; ?>
                        </div>
                    </td>
                    <td class="text-right text-nowrap">
                        <h5>
                            <span id="spec_<?php echo $_iii; ?>_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                            <span id="spec_<?php echo $_iii; ?>_text"><?php echo $this->lang['rcode']['y180402']; ?></span>
                        </h5>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".alert").hide();
        <?php for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
            $.ajax({
                url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec_gen", //url
                //async: false, //设置为同步
                type: "post",
                dataType: "json",
                data: {
                    act: "list",
                    page: "<?php echo $_iii; ?>",
                    <?php echo $this->common['tokenRow']['name_session']; ?>: "<?php echo $this->common['tokenRow']['token']; ?>"
                },
                success: function(_result){ //读取返回结果
                    _rcode_status  = _result.rcode.substr(0, 1);

                    switch (_rcode_status) {
                        case "x":
                            _class  = "text-danger";
                            _icon   = "glyphicon glyphicon-remove-sign";
                        break;

                        case "y":
                            _class  = "text-success";
                            _icon   = "glyphicon glyphicon-ok-sign";
                        break;
                    }

                    $("#spec_<?php echo $_iii; ?>_tr").attr("class", _class);
                    $("#spec_<?php echo $_iii; ?>_icon").attr("class", _icon);
                    $("#spec_<?php echo $_iii; ?>_text").text(_result.msg);
                }
            });
        <?php } ?>

        $(this).ajaxStop(function(){
            $(".alert").slideDown("slow");
            <?php include($cfg['pathInclude'] . "gen_foot.php"); ?>
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
