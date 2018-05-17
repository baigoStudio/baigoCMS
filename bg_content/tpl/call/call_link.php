    <ul role="<?php echo $this->tplData['callRow']['call_name']; ?>">
        <?php foreach ($this->tplData['linkRows'] as $key=>$value) { ?>
            <li>
                <a href="<?php echo $value['link_url']; ?>"<?php if ($value['link_blank'] > 0) { ?> target="_blank"<?php } ?>><?php echo $value['link_name']; ?></a>
            </li>
        <?php } ?>
    </ul>