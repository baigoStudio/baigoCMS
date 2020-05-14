<?php $cfg = array(
    'title'         => '首页',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="{:DIR_STATIC}cms/image/index_slide_1.jpg" class="img-fluid">
            </div>
            <div class="carousel-item">
                <img src="{:DIR_STATIC}cms/image/index_slide_2.jpg" class="img-fluid">
            </div>
        </div>

        <!-- Controls -->
        <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <?php $_arr_callRow = $call->get(5);

    foreach ($_arr_callRow['articleRows'] as $key=>$value) { ?>
        <div><?php echo $value['article_title']; ?></div>
    <?php }

include($cfg['pathInclude'] . 'index_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
