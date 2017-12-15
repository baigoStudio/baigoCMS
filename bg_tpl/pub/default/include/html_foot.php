    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

	<script type="text/javascript">
    function search_go_global() {
        var _search_key_global        = $("#search_key_global").val();
        var _search_customs_global    = $(".search_customs_global").serialize();
        window.location.href = "<?php echo BG_URL_ROOT; ?>search/key-" + encodeURIComponent(_search_key_global) + "/customs-" + encodeURIComponent(Base64.encode(_search_customs_global)) + "/";
	}

	$(document).ready(function(){
		$("#search_btn_global").click(function(){
			search_go_global();
		});

		$("#search_form_global").submit(function(){
			search_go_global();
			return false;
		});
	});
	</script>

    <!--
        <?php echo PRD_CMS_POWERED, ' ';
        if (BG_DEFAULT_UI == 'default') {
            echo PRD_CMS_NAME;
        } else {
            echo BG_DEFAULT_UI, ' CMS ';
        }
        echo PRD_CMS_VER; ?>
    -->

</body>
</html>