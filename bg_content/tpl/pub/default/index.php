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
            <div class="carousel-item active">
                <img src="<?php echo BG_URL_STATIC; ?>pub/default/image/index_slide_1.jpg" class="img-fluid">
            </div>
            <div class="carousel-item">
                <img src="<?php echo BG_URL_STATIC; ?>pub/default/image/index_slide_2.jpg" class="img-fluid">
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

    <?php $callRow = fn_callDisplay(7);

    foreach ($callRow as $key=>$value) { ?>
        <div><?php echo $key; ?></div>
    <?php }

include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php');