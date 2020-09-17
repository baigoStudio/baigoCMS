<?php $cfg = array(
    'title'         => $lang->get('Grabbing'),
    'noToken'       => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">
                        <?php echo $lang->get('Gathering site'); ?>:
                        <?php echo $gsiteRow['gsite_id']; ?>
                        -
                        <?php echo $gsiteRow['gsite_name']; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gatherRows as $key=>$value) { ?>
                    <tr>
                        <td>
                            <div><?php echo $value['content']; ?></div>
                            <div>
                                <small><?php echo $value['url']; ?></small>
                            </div>
                        </td>
                        <td id="gather_<?php echo $key; ?>" class="text-right text-nowrap">
                            <div class="text-info">
                                <span class="spinner-grow spinner-grow-sm"></span>
                                <small>
                                    <?php echo $lang->get('Grabbing'); ?>
                                </small>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (!empty($gatherRows)) {
            foreach ($gatherRows as $key=>$value) { ?>
                $.ajax({
                    url: '<?php echo $route_console; ?>grab/submit/?' + new Date().getTime() + 'at' + Math.random(), //url
                    //async: false, //设置为同步
                    type: 'post',
                    dataType: 'json',
                    data: {
                        gsite_id: '<?php echo $gsiteRow['gsite_id']; ?>',
                        url: '<?php echo $value['url']; ?>',
                        <?php echo $token['name']; ?>: '<?php echo $token['value']; ?>'
                    },
                    timeout: 30000,
                    error: function (result) {
                        $('#gather_<?php echo $key; ?> div').attr('class', 'text-danger');
                        $('#gather_<?php echo $key; ?> span').attr('class', 'fas fa-times-circle');
                        $('#gather_<?php echo $key; ?> small').text(result.statusText);
                    },
                    success: function(result){ //读取返回结果
                        _rcode_status  = result.rcode.substr(0, 1);

                        switch (_rcode_status) {
                            case 'y':
                                _class  = 'text-success';
                                _icon   = 'fas fa-check-circle';
                            break;

                            default:
                                _class  = 'text-danger';
                                _icon   = 'fas fa-times-circle';
                            break;
                        }

                        $('#gather_<?php echo $key; ?> div').attr('class', _class);
                        $('#gather_<?php echo $key; ?> span').attr('class', _icon);
                        $('#gather_<?php echo $key; ?> small').text(result.msg);
                    }
                });
            <?php } ?>

            $(this).ajaxStop(function(){
                setTimeout(function(){
                    window.location.href = '<?php echo $jump; ?>';
                }, 1000);
            });
        <?php } else { ?>
            setTimeout(function(){
                window.location.href = '<?php echo $jump; ?>';
            }, 1000);
        <?php } ?>
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);