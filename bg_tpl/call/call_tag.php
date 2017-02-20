    <ul role="<?php echo $this->tplData["callRow"]["call_name"]; ?>">
        <?php foreach ($this->tplData["tagRows"] as $key=>$value) { ?>
            <li>
                <a href="<?php echo $value["urlRow"]["tag_url"]; ?>"><?php echo $value["tag_name"]; ?></a>
            </li>
        <?php } ?>
    </ul>