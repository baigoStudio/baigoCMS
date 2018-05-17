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
                    <th><?php echo $this->lang['common']['label']['article']; ?></th>
                    <th class="text-right"><?php echo $this->lang['mod']['label']['status']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->tplData['articleRows'] as $_key=>$_value) { ?>
                    <tr id="article_<?php echo $_value['article_id']; ?>_tr" class="text-info">
                        <td>
                            <?php echo $_value['article_id']; ?>
                        </td>
                        <td>
                            <?php echo $_value['article_title']; ?>
                        </td>
                        <td class="text-right text-nowrap">
                            <span id="article_<?php echo $_value['article_id']; ?>_icon" class="oi oi-loop-circular bg-spin"></span>
                            <span id="article_<?php echo $_value['article_id']; ?>_text"><?php echo $this->lang['rcode']['y120402']; ?></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (!fn_isEmpty($this->tplData['articleRows'])) {
            foreach ($this->tplData['articleRows'] as $_key=>$_value) { ?>
                $.ajax({
                    url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=article_gen&c=request", //url
                    //async: false, //设置为同步
                    type: "post",
                    dataType: "json",
                    data: {
                        a: "single",
                        article_id: "<?php echo $_value['article_id']; ?>",
                        <?php if ($this->tplData['enforce'] == "true") { ?>
                            enforce: "true",
                        <?php }
                        echo $this->common['tokenRow']['name_session']; ?>: "<?php echo $this->common['tokenRow']['token']; ?>"
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

                        $("#article_<?php echo $_value['article_id']; ?>_tr").attr("class", _class);
                        $("#article_<?php echo $_value['article_id']; ?>_icon").attr("class", _icon);
                        $("#article_<?php echo $_value['article_id']; ?>_text").text(_result.msg);
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