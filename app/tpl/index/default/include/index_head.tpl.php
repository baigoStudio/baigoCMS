<?php include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

    <header class="navbar navbar-expand-md navbar-light bg-light justify-content-between align-items-center mb-3">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $dir_root; ?>">
                <?php echo $config['var_extra']['base']['site_name']; ?>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarNav">
                <form class="d-none d-md-block mr-auto" id="search_form_global" action="<?php echo $url_search; ?>">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="关键词" name="key" id="search_key_global">
						<span class="input-group-append">
							<button type="submit" class="btn btn-secondary">
								<span class="fas fa-search"></span>
							</button>
						</span>
					</div>
				</form>
				<ul class="navbar-nav">
                    <?php if (isset($cate_tree) && !empty($cate_tree)) {
                        foreach ($cate_tree as $key=>$value) { ?>
                            <li class="nav-item <?php if (isset($value['cate_childs']) && !empty($value['cate_childs'])) { ?>dropdown<?php } ?>">
                                <a class="nav-link <?php if (isset($value['cate_childs']) && !empty($value['cate_childs'])) { ?>dropdown-toggle<?php } ?>" href="<?php echo $value['cate_url']['url']; ?>" <?php if (isset($value['cate_childs']) && !empty($value['cate_childs'])) { ?>data-toggle="dropdown"<?php } ?>>
                                    <?php echo $value['cate_name']; ?>
                                </a>

                                <div class="dropdown-menu">
                                    <?php foreach ($value['cate_childs'] as $key_sub=>$value_sub) { ?>
                                        <a href="<?php echo $value_sub['cate_url']['url']; ?>" class="dropdown-item">
                                            <?php echo $value_sub['cate_name']; ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
