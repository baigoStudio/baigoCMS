    <?php
    if (!function_exists('page_process')) {
        function page_process($thisPage, $urlRow, $gen_open, $config) {
            if ($gen_open) {
                if ($thisPage <= $config['visit_pagecount']) {
                    $_str_echo = $urlRow['url'] . $urlRow['param'] . $thisPage . $urlRow['suffix'];
                } else {
                    $_str_echo = $urlRow['url_more'] . $urlRow['param_more'] . $thisPage;
                }
            } else {
                $_str_echo = $urlRow['url'] . $urlRow['param'] . $thisPage;
            }

            return $_str_echo;
        }
    }

    $_lang_pageFirst    = '首页';
    $_lang_pagePrevList = '上十页';
    $_lang_pagePrev     = '上页';
    $_lang_pageNext     = '下页';
    $_lang_pageNextList = '下十页';
    $_lang_pageEnd      = '末页';
    $_lang_pageMote     = '更多';

    if (!isset($urlRow)) {
        $urlRow = array(
            'url'           => '',
            'url_more'      => '',
            'param'         => '',
            'param_more'    => '',
            'suffix'        => '',
        );
    }

    if (!isset($pageRow)) {
       $pageRow = array(
            'page'          => 1,
            'first'         => 0,
            'final'         => 0,
            'prev'          => 0,
            'next'          => 0,
            'group_begin'   => 1,
            'group_end'     => 1,
            'group_prev'    => 0,
            'group_next'    => 0,
        );
    }

    if (!isset($gen_open)) {
        $gen_open = false;
    }

    if (isset($config['var_extra']['visit'])) {
        $_arr_config = $config['var_extra']['visit'];
    } else if (!isset($_arr_config)) {
        $_arr_config = array(
            'visit_pagecount' => 0,
        );
    } ?>

    <ul class="pagination">
        <?php if ($pageRow['first']) { ?>
            <li class="page-item">
                <a href="<?php echo page_process($pageRow['first'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pageFirst; ?>" class="page-link"><?php echo $_lang_pageFirst; ?></a>
            </li>
        <?php }

        if ($pageRow['group_prev']) { ?>
            <li class="page-item d-none d-lg-block">
                <a href="<?php echo page_process($pageRow['group_prev'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pagePrevList; ?>" class="page-link">...</a>
            </li>
        <?php } ?>

        <li class="page-item<?php if (!$pageRow['prev']) { ?> disabled<?php } ?>">
            <?php if ($pageRow['prev']) { ?>
                <a href="<?php echo page_process($pageRow['prev'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="fas fa-chevron-left"></span></a>
            <?php } else { ?>
                <span title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="fas fa-chevron-left"></span></span>
            <?php } ?>
        </li>

        <?php for ($iii = $pageRow['group_begin']; $iii <= $pageRow['group_end']; ++$iii) { ?>
            <li class="page-item<?php if ($iii == $pageRow['page']) { ?> active<?php } ?> d-none d-lg-block">
                <?php if ($iii == $pageRow['page']) { ?>
                    <span class="page-link"><?php echo $iii; ?></span>
                <?php } else { ?>
                    <a href="<?php echo page_process($iii, $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $iii; ?>" class="page-link"><?php echo $iii; ?></a>
                <?php } ?>
            </li>
        <?php } ?>

        <li class="page-item<?php if (!$pageRow['next']) { ?> disabled<?php } ?>">
            <?php if ($pageRow['next']) { ?>
                <a href="<?php echo page_process($pageRow['next'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="fas fa-chevron-right"></span></a>
            <?php } else { ?>
                <span title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="fas fa-chevron-right"></span></span>
            <?php } ?>
        </li>

        <?php if ($pageRow['group_next']) { ?>
            <li class="page-item d-none d-lg-block">
                <a href="<?php echo page_process($pageRow['group_next'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pageNextList; ?>" class="page-link">...</a>
            </li>
        <?php }

        if ($pageRow['final']) { ?>
            <li class="page-item">
                <a href="<?php echo page_process($pageRow['final'], $urlRow, $gen_open, $_arr_config); ?>" title="<?php echo $_lang_pageEnd; ?>" class="page-link"><?php echo $_lang_pageEnd; ?></a>
            </li>
        <?php }

        if (isset($page_more)) { ?>
            <li class="page-item">
                <a href="<?php echo $urlRow['url_more'], $urlRow['param_more'], $pageRow['group_end'] + 1; ?>" title="<?php echo $_lang_pageMote; ?>" class="page-link"><?php echo $_lang_pageMote; ?></a>
            </li>
        <?php } ?>

    </ul>