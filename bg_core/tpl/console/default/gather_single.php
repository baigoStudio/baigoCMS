<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['gathering'],
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
                <th><?php echo $this->lang['mod']['label']['title']; ?> / <?php echo $this->lang['mod']['label']['gsiteUrl']; ?></th>
                <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->tplData['gatherRows'] as $key=>$value) { ?>
                <tr id="gather_<?php echo $key; ?>_tr" class="text-info">
                    <td>
                        <h5>
                            <?php echo $value['content']; ?>
                        </h5>
                        <div>
                            <?php echo $value['url']; ?>
                        </div>
                    </td>
                    <td class="text-right text-nowrap">
                        <h5>
                            <span id="gather_<?php echo $key; ?>_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                            <span id="gather_<?php echo $key; ?>_text"><?php echo $this->lang['mod']['page']['gathering']; ?></span>
                        </h5>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php foreach ($this->tplData['gatherRows'] as $key=>$value) { ?>
            $.ajax({
                url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gather", //url
                //async: false, //设置为同步
                type: "post",
                dataType: "json",
                data: {
                    act: "submit",
                    gsite_id: "<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>",
                    key: "<?php echo $key; ?>",
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

                    $("#gather_<?php echo $key; ?>_tr").attr("class", _class);
                    $("#gather_<?php echo $key; ?>_icon").attr("class", _icon);
                    $("#gather_<?php echo $key; ?>_text").text(_result.msg);
                }
            });
        <?php } ?>

        $(this).ajaxStop(function(){
            <?php include($cfg['pathInclude'] . "gather_foot.php"); ?>
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>