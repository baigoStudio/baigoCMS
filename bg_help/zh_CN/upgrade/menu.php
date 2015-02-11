	<ul class="nav nav-pills nav-stacked menu_right">
		<li<?php if ($_str_act == "index") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=index">升级概述</a></li>
		<li<?php if ($_str_act == "dbtable") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=dbtable">升级数据表</a></li>
		<li<?php if ($_str_act == "base") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=base">基本设置</a></li>
		<li<?php if ($_str_act == "visit") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=visit">访问方式设置</a></li>
		<li<?php if ($_str_act == "upload") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=upload">上传设置</a></li>
		<li<?php if ($_str_act == "sso") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=sso">SSO 设置</a></li>
		<li<?php if ($_str_act == "over") { ?> class="active"<?php } ?>><a href="?lang=zh_CN&mod=upgrade&act=over">完成安装</a></li>
	</ul>
