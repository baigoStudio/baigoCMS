        <div class="form-group">
            <ul class="nav nav-pills bg-nav-pills">
                <li<?php if ($GLOBALS['route']['bg_act'] == 'form') { ?> class="active"<?php } ?>>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </li>
                <li<?php if ($GLOBALS['route']['bg_act'] == "stepList") { ?> class="active"<?php } ?>>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=stepList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <?php echo $this->lang['mod']['href']['stepList']; ?>
                    </a>
                </li>
                <li<?php if ($GLOBALS['route']['bg_act'] == "stepContent") { ?> class="active"<?php } ?>>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=stepContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-copy"></span>
                        <?php echo $this->lang['mod']['href']['stepContent']; ?>
                    </a>
                </li>
                <li<?php if ($GLOBALS['route']['bg_act'] == "stepPageList") { ?> class="active"<?php } ?>>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=stepPageList&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-duplicate"></span>
                        <?php echo $this->lang['mod']['href']['stepPageList']; ?>
                    </a>
                </li>
                <li<?php if ($GLOBALS['route']['bg_act'] == "stepPageContent") { ?> class="active"<?php } ?>>
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=stepPageContent&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-file"></span>
                        <?php echo $this->lang['mod']['href']['stepPageContent']; ?>
                    </a>
                </li>
                <li>
                    <a href="#selector_modal" data-toggle="modal">
                        <span class="glyphicon glyphicon-question-sign"></span>
                        <?php echo $this->lang['mod']['href']['helpSelector']; ?>
                    </a>
                </li>
            </ul>
        </div>