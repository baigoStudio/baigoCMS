     <ul role="<?php echo $callRow['call_name']; ?>">
        <?php if (isset($articleRows) && !empty($articleRows)) {
            foreach ($articleRows as $key=>$value) { ?>
                <li>
                    <a href="<?php echo $value['article_url']; ?>"><?php echo $value['article_title']; ?></a>
                </li>
            <?php }
        } ?>
    </ul>
