<?php $cfg = array(
    'pathInclude'   => $path_tpl . 'include' . DS,
    'prism'         => 'true',
);

include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

    <div class="container-fluid">
        <pre class="bg-pre-nostyle"><code class="language-markup"><?php echo $sourceRow['content']; ?></code></pre>
    </div>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);