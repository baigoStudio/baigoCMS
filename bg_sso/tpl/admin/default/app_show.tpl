{* admin_form.tpl 管理员编辑界面 *}
{$cfg = [
	title          => "{$adminMod.app.main.title} - {$lang.page.detail}",
	css            => "admin_form",
	menu_active    => "app",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h1>

	</h1>

	<form class="tform">
		<div>
			<ol>
				<li class="title_b">
					{$lang.label.id}: {$tplData.appRow.app_id}
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.status}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.appRow.app_status == "enable"}y{else}x{/if}.png" />
					<label>{$status.app[$tplData.appRow.app_status]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title">{$lang.label.sync}</li>
				<li>
					<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.appRow.app_sync == "on"}y{else}x{/if}.png" />
					<label>{$status.appSync[$tplData.appRow.app_sync]}</label>
				</li>

				<li class="line_dashed"> </li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&act_get=form&app_id={$tplData.appRow.app_id}">{$lang.href.edit}</a>
				</li>
			</ol>

			<ul>
				<li class="title">{$lang.label.appName}</li>
				<li class="title_b">{$tplData.appRow.app_name}</li>

				<li class="title">{$lang.label.apiUrl}</li>
				<li class="title_b">{$smarty.const.BG_SITE_URL}{$smarty.const.BG_URL_API}api.php</li>

				<li class="title">{$lang.label.appId}</li>
				<li class="title_b">{$tplData.appRow.app_id}</li>

				<li class="title">{$lang.label.appKey}</li>
				<li class="title_b">{$tplData.appRow.app_key}</li>

				<li class="title">{$lang.label.appNotice}</li>
				<li class="title_b">{$tplData.appRow.app_notice}</li>

				<li class="title">{$lang.label.allow}</li>
				<li>
					<ol>
						{foreach $allow as $key_m=>$value_m}
							<li class="title">{$value_m.title}</li>
							<li class="field">
								{foreach $value_m.allow as $key_s=>$value_s}
									<img src="{$smarty.const.BG_URL_IMAGE}allow_{if $tplData.appRow.app_allow[$key_m][$key_s] == 1}y{else}x{/if}.png" />
									<label>{$value_s}</label>
								{/foreach}
							</li>
						{/foreach}
					</ol>
				</li>

				<li class="title">{$lang.label.ipAllow}</li>
				<li class="title_b">
					<pre>{$tplData.appRow.app_ip_allow}</pre>
				</li>

				<li class="title">{$lang.label.ipBad}</li>
				<li>
					<pre>{$tplData.appRow.app_ip_bad}</pre>
				</li>

				<li class="title">{$lang.label.note}</li>
				<li class="title_b">{$tplData.appRow.app_note}</li>

				<li class="title_b">
					<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=app&act_get=form&app_id={$tplData.appRow.app_id}">{$lang.href.edit}</a>
				</li>
			</ul>
		</div>
	</form>

{include "include/admin_foot.tpl" cfg=$cfg}

{include "include/html_foot.tpl" cfg=$cfg}
