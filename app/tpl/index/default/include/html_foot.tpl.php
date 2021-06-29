    <?php use ginkgo\Plugin;

    Plugin::listen('action_pub_foot_before');

    if (isset($cfg['baigoDialog'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="{:DIR_STATIC}lib/baigoDialog/1.1.0/baigoDialog.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['prism'])) { ?>
        <script src="{:DIR_STATIC}lib/prism/prism.min.min.js" type="text/javascript"></script>
    <?php } ?>

    <script src="{:DIR_STATIC}lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (isset($cfg['popover'])) { ?>
            $('[data-toggle="popover"]').popover({
                html: true,
                template: '<div class="popover bg-popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
            });
        <?php }

        if (isset($cfg['tooltip'])) { ?>
            $('[data-toggle="tooltip"]').tooltip({
                html: true,
                template: '<div class="tooltip bg-tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });
        <?php }

        if (isset($cfg['imageAsync'])) { ?>
            $('[data-toggle="async"]').each(function(){
                var _src = $(this).data('src');
                $(this).attr('src', _src);

                $(this).one('error', function(){
                    $(this).attr('src', '{:DIR_STATIC}image/notfound.svg');
                });
            });
        <?php } ?>
    });
    </script>

    <script src="{:DIR_STATIC}lib/bootstrap/4.5.2/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Powered by <?php echo PRD_CMS_NAME, ' ', PRD_CMS_VER; ?> -->

    <?php Plugin::listen('action_pub_foot_after'); ?>
</body>
</html>
