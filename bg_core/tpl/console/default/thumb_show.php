<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['attach']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['attach']['sub']['thumb'],
    'menu_active'    => 'attach',
    'sub_active'     => "thumb",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
    "baigoClear"     => "true"
);

include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=thumb&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo BG_URL_HELP; ?>index.php?m=console&a=attach#thumb" class="nav-link" target="_blank">
                <span class="badge badge-pill badge-primary">
                    <span class="oi oi-question-mark"></span>
                </span>
                <?php echo $this->lang['mod']['href']['help']; ?>
            </a>
        </li>
    </ul>

    <form name="thumb_gen" id="thumb_gen">
        <input type="hidden" name="<?php echo $this->common['tokenRow']['name_session']; ?>" value="<?php echo $this->common['tokenRow']['token']; ?>">
        <input type="hidden" name="thumb_id" value="<?php echo $this->tplData['thumbRow']['thumb_id']; ?>">
        <input type="hidden" name="a" id="act_gen" value="gen">

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['rangeId']; ?></label>
                            <div class="input-group">
                                <input type="text" name="attach_range[min_id]" id="attach_range_min_id" value="0" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text border-right-0"><?php echo $this->lang['mod']['label']['to']; ?></span>
                                </div>
                                <input type="text" name="attach_range[max_id]" id="attach_range_max_id" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_gen">
                                <span class="oi oi-loop-circular"></span>
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
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['thumbRow']['thumb_id']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['thumbWidth']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['thumbRow']['thumb_width']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['thumbHeight']; ?></label>
                            <div class="form-text"><?php echo $this->tplData['thumbRow']['thumb_height']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['thumbCall']; ?></label>
                            <div class="form-text">thumb_<?php echo $this->tplData['thumbRow']['thumb_width']; ?>_<?php echo $this->tplData['thumbRow']['thumb_height']; ?>_<?php echo $this->tplData['thumbRow']['thumb_type']; ?></div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['thumbType']; ?></label>
                            <div class="form-text">
                                <?php if (isset($this->lang['mod']['type'][$this->tplData['thumbRow']['thumb_type']])) {
                                    echo $this->lang['mod']['type'][$this->tplData['thumbRow']['thumb_type']];
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include($cfg['pathInclude'] . 'console_foot.php'); ?>

    <script type="text/javascript">
    var opts_gen = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>index.php?m=attach&c=request",
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

<?php include('include' . DS . 'html_foot.php');