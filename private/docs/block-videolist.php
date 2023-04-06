<div class="card-wrapper flex-wrap">
    <?php
    if (sizeof($videoCollection)) {
        foreach ($videoCollection as $video) {
            require __DIR__ . '/card-video.php';
        }
    } ?>
</div>