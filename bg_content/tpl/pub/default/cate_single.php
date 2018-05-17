<?php $cfg = array(
    'title'      => $this->tplData['cateRow']['cate_name']
);

include('include' . DS . 'pub_head.php');

    include('include' . DS . 'breadcrumb.php'); ?>

    <h3><?php echo $this->tplData['cateRow']['cate_name']; ?></h3>

    <div>
        <?php echo $this->tplData['cateRow']['cate_content']; ?>
    </div>

<?php include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php');