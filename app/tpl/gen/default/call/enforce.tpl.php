<?php $cfg = array(
    'title'         => $lang->get('Generating'),
    'baigoQuery'    => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

            <div class="container-fluid my-3">
                <form name="article_gen" id="article_gen" action="<?php echo $route_gen; ?>article/index/enforce/enforce/view/iframe/">
                    <div class="alert alert-warning">
                        <?php echo $lang->get('Generate enforce'); ?>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->get('ID range'); ?></label>
                        <div class="input-group">
                            <input type="text" name="range_min" id="range_min" value="0" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text border-right-0"><?php echo $lang->get('To'); ?></span>
                            </div>
                            <input type="text" name="range_max" id="range_max" value="0" class="form-control">
                        </div>
                        <small class="form-text"><?php echo $lang->get('<kbd>0</kbd> is unlimited'); ?></small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                            <span class="oi oi-loop-circular"></span>
                            <?php echo $lang->get('Generate'); ?>
                        </button>
                    </div>
                </form>
            </div>

    <script type="text/javascript">
    $(document).ready(function(){
        var obj_query = $('#article_gen').baigoQuery();

        $('#article_gen').submit(function(){
            obj_query.formSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
