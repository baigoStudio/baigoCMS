    <?php
    if (!isset($articleRow)) {
        $articleRow = array(
            'article_box'           => 'normal',
            'article_is_time_pub'   => 0,
            'article_time_pub'      => GK_NOW,
            'article_time_pub_format'  => array(
                'date_time' => date('Y-m-d'),
            ),
            'article_is_time_hide'  => 0,
            'article_time_hide'     => GK_NOW,
            'article_time_hide_format' => array(
                'date_time' => date('Y-m-d'),
            ),
            'article_top'           => 0,
            'article_status'        => '',
            'article_box'           => '',
        );
    }

    $_str_css       = 'secondary';
    $_str_status    = $lang->get($articleRow['article_status']);
    $_str_title     = '';

    switch ($articleRow['article_box']) {
        case 'normal':
            switch ($articleRow['article_status']) {
                case 'pub':
                    if ($articleRow['article_is_time_pub'] > 0 && $articleRow['article_time_pub'] > GK_NOW) {
                        $_str_css       = 'info';
                        $_str_status    = $lang->get('Scheduled publish');
                        $_str_title     = $lang->get('Scheduled publish') . ' ' . $articleRow['article_time_pub_format']['date_time'];
                    } else if ($articleRow['article_is_time_hide'] > 0 && $articleRow['article_time_hide'] < GK_NOW) {
                        $_str_status    = $lang->get('Scheduled offline');
                        $_str_title     = $lang->get('Scheduled offline') . ' ' . $articleRow['article_time_hide_format']['date_time'];
                    } else {
                        if ($articleRow['article_top'] > 0) {
                            $_str_status    = $lang->get('Sticky');
                            $_str_css       = 'primary';
                        } else {
                            $_str_css       = 'success';
                        }
                    }
                break;

                case 'wait':
                    $_str_css = 'warning';
                break;

                default:
                    $_str_css = 'secondary';
                break;
            }
        break;

        default:
            $_str_css       = 'secondary';
            $_str_status    = $lang->get($articleRow['article_box']);
        break;
    } ?>
    <span class="badge badge-<?php echo $_str_css; ?>" <?php if (!empty($_str_title)) { ?>data-toggle="tooltip" data-placement="bottom" title="<?php echo $_str_title; ?>"<?php } ?>><?php echo $_str_status; ?></span>


