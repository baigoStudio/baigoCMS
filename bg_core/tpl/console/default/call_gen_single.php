<?php $cfg = array(
    'title'         => $this->lang['common']['page']['gening'],
    'noToken'       => 'true',
    'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head.php'); ?>

    <style type="text/css">
    body {
        padding: 0 15px;
    }
    </style>

    <table class="table">
        <thead>
            <tr>
                <th><?php echo $this->lang['common']['label']['call']; ?> / <?php echo $this->lang['mod']['label']['id']; ?></th>
                <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody>
            <tr id="call_<?php echo $this->tplData['callRow']['call_id']; ?>_tr" class="text-info">
                <td>
                    <h5>
                        <?php echo $this->tplData['callRow']['call_name']; ?>
                    </h5>
                    <div>
                        <?php echo $this->tplData['callRow']['call_id']; ?>
                    </div>
                </td>
                <td class="text-right text-nowrap">
                    <h5>
                        <span id="call_<?php echo $this->tplData['callRow']['call_id']; ?>_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                        <span id="call_<?php echo $this->tplData['callRow']['call_id']; ?>_text"><?php echo $this->lang['rcode']['y170402']; ?></span>
                    </h5>
                </td>
            </tr>
        </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=call_gen", //url
            //async: false, //设置为同步
            type: "post",
            dataType: "json",
            data: {
                act: "single",
                call_id: "<?php echo $this->tplData['callRow']['call_id']; ?>",
                enforce: "true",
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

                $("#call_<?php echo $this->tplData['callRow']['call_id']; ?>_tr").attr("class", _class);
                $("#call_<?php echo $this->tplData['callRow']['call_id']; ?>_icon").attr("class", _icon);
                $("#call_<?php echo $this->tplData['callRow']['call_id']; ?>_text").text(_result.msg);
            }
        });

        $(this).ajaxStop(function(){
            <?php include($cfg['pathInclude'] . "gen_foot.php"); ?>
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
