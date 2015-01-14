	<div class="col-md-3">
		<div class="well">
			<div class="form-group">
				<label class="control-label">{$lang.label.id}</label>
				<p class="form-control-static">{$tplData.adminLogged.admin_id}</p>
			</div>

			{if $tplData.adminLogged.admin_status == "enable"}
				{$_css_status = "success"}
			{else}
				{$_css_status = "danger"}
			{/if}

			<div class="form-group">
				<label class="control-label">{$lang.label.status}</label>
				<p class="form-control-static">
					<span class="label label-{$_css_status}">{$status.admin[$tplData.adminLogged.admin_status]}</span>
				</p>
			</div>

			{if $tplData.adminLogged.admin_allow_profile.info == "1"}
				<div class="form-group">
					<span class="label label-danger">{$lang.label.profileInfo}</span>
				</div>
			{/if}

			{if $tplData.adminLogged.admin_allow_profile.pass == "1"}
				<div class="form-group">
					<span class="label label-danger">{$lang.label.profilePass}</span>
				</div>
			{/if}

			<div class="form-group">
				<label class="control-label">{$lang.label.adminGroup}</label>
				<p class="form-control-static">
					{if isset($tplData.adminLogged.groupRow.group_name)}
						{$tplData.adminLogged.groupRow.group_name} | <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=show&group_id={$tplData.adminLogged.admin_group_id}">{$lang.href.show}</a>
					{else}
						{$lang.label.none}
					{/if}
				</p>
			</div>
		</div>
	</div>