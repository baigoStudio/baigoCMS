<?php $cfg = array(
    'title'         => $this->lang['mod']['page']['storing'],
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
                <th><?php echo $this->lang['mod']['label']['title']; ?> / <?php echo $this->lang['mod']['label']['id']; ?></th>
                <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->tplData['gatherRows'] as $_key=>$_value) { ?>
                <tr id="gather_<?php echo $_value['gather_id']; ?>_tr" class="text-info">
                    <td>
                        <h5>
                            <?php echo $_value['gather_title']; ?>
                        </h5>
                        <div>
                            <?php echo $_value['gather_id']; ?>
                        </div>
                    </td>
                    <td class="text-right text-nowrap">
                        <h5>
                            <span id="gather_<?php echo $_value['gather_id']; ?>_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                            <span id="gather_<?php echo $_value['gather_id']; ?>_text"><?php echo $this->lang['rcode']['y280402']; ?></span>
                        </h5>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (!fn_isEmpty($this->tplData['gatherRows'])) {
            foreach ($this->tplData['gatherRows'] as $_key=>$_value) { ?>
                $.ajax({
                    url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=gather", //url
                    //async: false, //设置为同步
                    type: "post",
                    dataType: "json",
                    data: {
                        act: "store",
                        enforce: <?php echo $this->tplData['enforce']; ?>,
                        gather_id: "<?php echo $_value['gather_id']; ?>",
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

                        $("#gather_<?php echo $_value['gather_id']; ?>_tr").attr("class", _class);
                        $("#gather_<?php echo $_value['gather_id']; ?>_icon").attr("class", _icon);
                        $("#gather_<?php echo $_value['gather_id']; ?>_text").text(_result.msg);
                    }
                });
            <?php } ?>
            $(this).ajaxStop(function(){
                setTimeout(function(){
                    //window.location.href = "<?php echo $this->tplData['jump']; ?>";
                }, 1000);
            });
        <?php } else { ?>
            setTimeout(function(){
                //window.location.href = "<?php echo $this->tplData['jump']; ?>";
            }, 1000);
        <?php } ?>
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
