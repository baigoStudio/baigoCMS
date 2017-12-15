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
                <th><?php echo $this->lang['common']['label']['cate']; ?> / <?php echo $this->lang['mod']['label']['pageNo']; ?></th>
                <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
                <tr id="cate_<?php echo $_iii; ?>_tr" class="text-info">
                    <td>
                        <h5>
                            <?php echo $this->tplData['cateRow']['cate_name']; ?>
                        </h5>
                        <div>
                            <?php echo $this->lang['mod']['label']['pageCount']; ?> <?php echo $_iii; ?> <?php echo $this->lang['mod']['label']['pagePage']; ?>
                        </div>
                    </td>
                    <td class="text-right text-nowrap">
                        <h5>
                            <span id="cate_<?php echo $_iii; ?>_icon" class="glyphicon glyphicon-refresh bg-spin"></span>
                            <span id="cate_<?php echo $_iii; ?>_text"><?php echo $this->lang['rcode']['y250402']; ?></span>
                        </h5>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
            $.ajax({
                url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate_gen", //url
                //async: false, //设置为同步
                type: "post",
                dataType: "json",
                data: {
                    act: "single",
                    cate_id: "<?php echo $this->tplData['cateRow']['cate_id']; ?>",
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

                    $("#cate_<?php echo $_iii; ?>_tr").attr("class", _class);
                    $("#cate_<?php echo $_iii; ?>_icon").attr("class", _icon);
                    $("#cate_<?php echo $_iii; ?>_text").text(_result.msg);
                }
            });
        <?php } ?>

        $(this).ajaxStop(function(){
            <?php include($cfg['pathInclude'] . "gen_foot.php"); ?>
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>
