<?php $cfg = array(
    "title"      => $this->tplData["cateRow"]["cate_name"]
);

include("include/pub_head.php");

    include("include/breadcrumb.php"); ?>

    <h3><?php echo $this->tplData["cateRow"]["cate_name"]; ?></h3>

    <p>
        <?php echo $this->tplData["cateRow"]["cate_content"]; ?>
    </p>

<?php include("include/pub_foot.php");
include("include/html_foot.php"); ?>