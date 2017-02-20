    <ul role="<?php echo $this->tplData["callRow"]["call_name"]; ?>">
        <?php foreach ($this->tplData["articleRows"] as $key=>$value) { ?>
            <li>
                <a href="<?php echo $value["urlRow"]["article_url"]; ?>"><?php echo $value["article_title"]; ?></a>
            </li>
        <?php } ?>
    </ul>