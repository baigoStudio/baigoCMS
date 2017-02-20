    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo $this->consoleMod["cate"]["main"]["title"] . " &raquo; " . $this->lang["page"]["order"]; ?>
    </div>
    <div class="modal-body">
        <form name="cate_order" id="cate_order" class="form_input">
            <input type="hidden" name="<?php echo $this->common["tokenRow"]["name_session"]; ?>" value="<?php echo $this->common["tokenRow"]["token"]; ?>">
            <input type="hidden" name="act" value="order">
            <input type="hidden" name="cate_id" value="<?php echo $this->tplData["cateRow"]["cate_id"]; ?>">
            <input type="hidden" name="cate_parent_id" value="<?php echo $this->tplData["cateRow"]["cate_parent_id"]; ?>">

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["id"]; ?></label>
                <div class="form-control-static"><?php echo $this->tplData["cateRow"]["cate_id"]; ?></div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo $this->lang["label"]["cateName"]; ?></label>
                <div class="form-control-static"><?php echo $this->tplData["cateRow"]["cate_name"]; ?></div>
            </div>

            <div class="form-group">
                <div id="group_order_type">
                    <label class="control-label"><?php echo $this->lang["label"]["order"]; ?><span id="msg_order_type">*</span></label>
                    <div class="radio">
                        <label for="order_first">
                            <input type="radio" name="order_type" id="order_first" value="order_first" checked data-validate="order_type">
                            <?php echo $this->lang["label"]["orderFirst"]; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label for="order_last">
                            <input type="radio" name="order_type" id="order_last" value="order_last" data-validate="order_type">
                            <?php echo $this->lang["label"]["orderLast"]; ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label for="order_after">
                            <input type="radio" name="order_type" id="order_after" value="order_after" data-validate="order_type">
                            <input type="text" name="order_target" class="form-control" placeholder="<?php echo $this->lang["label"]["orderAfter"]; ?>">
                        </label>
                    </div>
                </div>
            </div>
        </form>

        <div class="bg-submit-box bg-submit-box-modal"></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary bg-submit-modal"><?php echo $this->lang["btn"]["save"]; ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang["btn"]["cancel"]; ?></button>
    </div>

    <script type="text/javascript">
    var opts_validator_order = {
        order_type: {
            len: { min: 1, max: 0 },
            validate: { selector: "input[name='order_type']", type: "radio", group: "#group_order_type" },
            msg: { selector: "#msg_order_type", too_few: "<?php echo $this->rcode["x250219"]; ?>" }
        }
    };

    var opts_submit_order = {
        ajax_url: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=cate",
        msg_text: {
            submitting: "<?php echo $this->lang["label"]["submitting"]; ?>"
        },
        box: {
            selector: ".bg-submit-box-modal"
        },
        selector: {
            submit_btn: ".bg-submit-modal"
        }
    };

    $(document).ready(function(){
        var obj_validate_order = $("#cate_order").baigoValidator(opts_validator_order);
        var obj_submit_order   = $("#cate_order").baigoSubmit(opts_submit_order);
        $(".bg-submit-modal").click(function(){
            if (obj_validate_order.verify()) {
                obj_submit_order.formSubmit();
            }
        });
    });
    </script>