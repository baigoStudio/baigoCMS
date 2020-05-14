        <div class="modal-header">
            <div class="modal-title"><?php echo $lang->get('Article source', 'console.common'), ' &raquo; ', $lang->get('Show'); ?></div>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label><?php echo $lang->get('ID'); ?></label>
                <div class="form-text"><?php echo $sourceRow['source_id']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Name'); ?></label>
                <div class="form-text"><?php echo $sourceRow['source_name']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Author'); ?></label>
                <div class="form-text"><?php echo $sourceRow['source_author']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('URL'); ?></label>
                <div class="form-text"><?php echo $sourceRow['source_url']; ?></div>
            </div>

            <div class="form-group">
                <label><?php echo $lang->get('Note'); ?></label>
                <div class="form-text"><?php echo $sourceRow['source_note']; ?></div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                <?php echo $lang->get('Close', 'console.common'); ?>
            </button>
        </div>
