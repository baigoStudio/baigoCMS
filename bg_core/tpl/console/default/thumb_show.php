<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['thumb'],
    'menu_active'    => 'attach',
    'sub_active'     => "thumb",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    "baigoClear"     => "true"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=thumb&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=attach#thumb" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <form name="thumb_gen" id="thumb_gen">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="thumb_id" value="<?php echo $this->tplData['thumbRow']['thumb_id']; ?>">
        <input type="hidden" name="act" id="act_gen" value="gen">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['rangeId']; ?></label>
                            <div class="input-group">
                                <input type="text" name="attach_range[min_id]" id="attach_range_min_id" value="0" class="form-control">
                                <span class="input-group-addon bg-input-range"><?php echo $this->lang['mod']['label']['to']; ?></span>
                                <input type="text" name="attach_range[max_id]" id="attach_range_max_id" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_gen">
                                <span class="glyphicon glyphicon-refresh"></span>
                                <?php echo $this->lang['mod']['btn']['thumbGen']; ?>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="baigoClearMsg">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['thumbRow']['thumb_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['thumbWidth']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['thumbRow']['thumb_width']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['thumbHeight']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['thumbRow']['thumb_height']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['thumbCall']; ?></label>
                        <div class="form-control-static">thumb_<?php echo $this->tplData['thumbRow']['thumb_width']; ?>_<?php echo $this->tplData['thumbRow']['thumb_height']; ?>_<?php echo $this->tplData['thumbRow']['thumb_type']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['thumbType']; ?></label>
                        <div class="form-control-static">
                            <?php if (isset($this->lang['mod']['type'][$this->tplData['thumbRow']['thumb_type']])) {
                                echo $this->lang['mod']['type'][$this->tplData['thumbRow']['thumb_type']];
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_gen = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach",
        confirm: {
            selector: "#act_gen",
            val: "gen",
            msg: "<?php echo $this->lang['mod']['confirm']['gen']; ?>"
        },
        msg: {
            loading: "<?php echo $this->lang['rcode']['x070409']; ?>",
            complete: "<?php echo $this->lang['rcode']['y070409']; ?>"
        }
    };

    $(document).ready(function(){
        var obj_gen = $("#thumb_gen").baigoClear(opts_gen);
        $("#go_gen").click(function(){
            obj_gen.clearSubmit();
        });
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>