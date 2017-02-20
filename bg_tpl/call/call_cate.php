    <ul role="<?php echo $this->tplData["callRow"]["call_name"]; ?>">
        <?php foreach ($this->tplData["cateRows"] as $key=>$value) { ?>
            <li>
                <a href="<?php echo $value["urlRow"]["cate_url"]; ?>"><?php echo $value["cate_name"]; ?></a>
            </li>
        <?php } ?>
    </ul>