    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == 'form') { ?> active<?php } ?>">
                    <span class="oi oi-pencil"></span>
                    <?php echo $this->lang['mod']['href']['edit']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=stepList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == "stepList") { ?> active<?php } ?>">
                    <span class="oi oi-list"></span>
                    <?php echo $this->lang['mod']['href']['stepList']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=stepContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == "stepContent") { ?> active<?php } ?>">
                    <span class="oi oi-file"></span>
                    <?php echo $this->lang['mod']['href']['stepContent']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=stepPageList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == "stepPageList") { ?> active<?php } ?>">
                    <span class="oi oi-browser"></span>
                    <?php echo $this->lang['mod']['href']['stepPageList']; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=stepPageContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>" class="nav-link<?php if ($GLOBALS['route']['bg_act'] == "stepPageContent") { ?> active<?php } ?>">
                    <span class="oi oi-clipboard"></span>
                    <?php echo $this->lang['mod']['href']['stepPageContent']; ?>
                </a>
            </li>
        </ul>
    </div>