    <ul role="<?php echo $callRow['call_name']; ?>">
        <?php if (isset($cateRows) && !empty($cateRows)) {
            foreach ($cateRows as $key=>$value) { ?>
                <li>
                    <a href="<?php echo $value['cate_url']['url']; ?>"><?php echo $value['cate_name']; ?></a>
                </li>
            <?php }
        } ?>
    </ul>