<div class="card-wrapper playlist-wrapper">
    <?php
    if (sizeof($playlistCollection)) {
        foreach ($playlistCollection as $playlist) {
            require __DIR__ . '/card-playlist.php';
        }
    } ?>
</div>