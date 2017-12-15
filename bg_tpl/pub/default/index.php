<?php $cfg = array(
    'title' => '首页',
);

include('include' . DS . 'pub_head.php'); ?>

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="<?php echo BG_URL_STATIC; ?>pub/default/image/index_slide_1.jpg">
            </div>
            <div class="item">
                <img src="<?php echo BG_URL_STATIC; ?>pub/default/image/index_slide_2.jpg">
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <?php $callRow = fn_callDisplay(7);

    foreach ($callRow as $key=>$value) { ?>
        <div><?php echo $key; ?></div>
    <?php }

include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php'); ?>