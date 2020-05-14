        <p class="bg-album bg-album-<?php echo $albumRow['album_id']; ?>">
            <a href="<?php echo $albumRow['album_url']['url']; ?>" title="<?php echo $albumRow['album_name']; ?>" target="_blank">
                <?php if (empty($attachRow['thumb_default'])) {
                    echo $albumRow['album_name'];
                } else { ?>
                    <img src="<?php echo $attachRow['thumb_default']; ?>" data-id="<?php echo $albumRow['album_id']; ?>" alt="<?php echo $albumRow['album_name']; ?>" title="<?php echo $albumRow['album_name']; ?>" class="img-fluid">
                <?php } ?>
            </a>
        </p>

