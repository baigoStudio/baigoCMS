<?php $cfg = array(
    'pathInclude'   => $path_tpl . 'include' . DS,
    'prism'         => 'true',
);

include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

    <div class="bg-light sticky-top border-bottom">
        <div class="container-fluid">
            <div class="py-2">
                 <input type="text" class="form-control form-control-sm bg-white" readonly value="<?php echo $sourceRow['url']; ?>">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <pre class="bg-pre-nostyle p-0"><code class="language-markup"><?php echo $sourceRow['content']; ?></code></pre>
    </div>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);