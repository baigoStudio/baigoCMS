    <script src="{$smarty.const.BG_URL_STATIC}js/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

	<script type="text/javascript">
    function search_go_global() {
        var _search_key_global        = $("#search_key_global").val();
        var _search_customs_global    = $(".search_customs_global").serialize();
        window.location.href = "{$smarty.const.BG_URL_ROOT}search/key-" + encodeURIComponent(_search_key_global) + "/customs-" + encodeURIComponent(Base64.encode(_search_customs_global)) + "/";
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

    <!-- {$smarty.const.PRD_CMS_POWERED} {if $config.ui == "default"}{$smarty.const.PRD_CMS_NAME}{else}{$config.ui} CMS{/if} {$smarty.const.PRD_CMS_VER} -->

</body>
</html>