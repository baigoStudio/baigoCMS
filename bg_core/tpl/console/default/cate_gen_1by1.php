<?php $cfg = array(
    'title'         => $this->lang['common']['page']['gening'],
    'noToken'       => 'true',
    'pathInclude'   => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head.php'); ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo $this->lang['mod']['label']['id']; ?></th>
                    <th><?php echo $this->lang['common']['label']['cate']; ?></th>
                    <th><?php echo $this->lang['mod']['label']['pageNo']; ?></th>
                    <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($this->tplData['cateRow']['rcode'] == 'y250102') {
                    for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
                        <tr id="cate_<?php echo $_iii; ?>_tr" class="text-info">
                            <td>
                                <?php echo $this->tplData['cateRow']['cate_id']; ?>
                            </td>
                            <td>
                                <?php echo $this->tplData['cateRow']['cate_name']; ?>
                            </td>
                            <td>
                                <?php echo $_iii; ?> / <?php echo $this->tplData['pageRow']['total']; ?>
                            </td>
                            <td class="text-right text-nowrap">
                                <span id="cate_<?php echo $_iii; ?>_icon" class="oi oi-loop-circular bg-spin"></span>
                                <span id="cate_<?php echo $_iii; ?>_text"><?php echo $this->lang['rcode']['y250402']; ?></span>
                            </td>
                        </tr>
                    <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if ($this->tplData['cateRow']['rcode'] == 'y250102') {
            for ($_iii = 1; $_iii <= $this->tplData['pageRow']['total']; $_iii++) { ?>
                $.ajax({
                    url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=cate_gen&c=request", //url
                    //async: false, //设置为同步
                    type: "post",
                    dataType: "json",
                    data: {
                        a: "single",
                        cate_id: "<?php echo $this->tplData['cateRow']['cate_id']; ?>",
                        page: "<?php echo $_iii; ?>",
                        <?php echo $this->common['tokenRow']['name_session']; ?>: "<?php echo $this->common['tokenRow']['token']; ?>"
                    },
                    success: function(_result){ //读取返回结果
                        _rcode_status  = _result.rcode.substr(0, 1);

                        switch (_rcode_status) {
                            case "x":
                                _class  = "text-danger";
                                _icon   = "oi oi-circle-x";
                            break;

                            case "y":
                                _class  = "text-success";
                                _icon   = "oi oi-circle-check";
                            break;
                        }

                        $("#cate_<?php echo $_iii; ?>_tr").attr("class", _class);
                        $("#cate_<?php echo $_iii; ?>_icon").attr("class", _icon);
                        $("#cate_<?php echo $_iii; ?>_text").text(_result.msg);
                    }
                });
            <?php } ?>

            $(this).ajaxStop(function(){
                setTimeout(function(){
                    window.location.href = "<?php echo $this->tplData['jump']; ?>";
                }, 1000);
            });
        <?php } else { ?>
            setTimeout(function(){
                window.location.href = "<?php echo $this->tplData['jump']; ?>";
            }, 1000);
        <?php } ?>
    });
    </script>

<?php include('include' . DS . 'html_foot.php');