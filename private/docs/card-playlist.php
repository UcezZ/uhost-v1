<div class="playlist-item card">
    <div class="card-header ">
        <?= $playlist->getName() ?>
        <form class="delete toggle-wrapper" method="POST" action="./playlist-remove.php">
            <input type="hidden" name="p" value="<?= $playlist->getId() ?>" />
            <span class="centerer-wrapper"><?= Locale::getValue('delete.confirm') ?></span>
            <div class="centerer-wrapper">
                <input id="checkbox<?= $playlist->getId() ?>" type="checkbox" required />
                <label for="checkbox<?= $playlist->getId() ?>">
                    <span></span>
                </label>
            </div>
            <button type="submit">
                <img src="./media/icons/delete.svg">
            </button>
        </form>
    </div>
    <div class="card-contents">
        <div class="preview">
            <img <?= !sizeof($playlist->getEntries()) ? 'class="empty"' : '' ?>src="<?= sizeof($playlist->getEntries()) ? './video.php?v=' . $playlist->getEntries()[0]->getAlias() . '&q=thumbnail' : './media/icons/video-empty.svg' ?>">
            <span><?= Locale::getValue('playlist.elements') ?>: <?= sizeof($playlist->getEntries()) ?></span>
        </div>
        <div class="contents">
            <?php
            if (!sizeof($playlist->getEntries())) {
                $errorCaption = Locale::getValue('playlist.error.empty');
                $errorMessage = Locale::getValue('playlist.error.empty.message');
                require __DIR__ . '/card-error.php';
            } else {
                foreach ($playlist->getEntries() as $video) {
                    require __DIR__ . '/item-playlistentry.php';
                }
            }
            ?>
        </div>
    </div>
    <div class="card-footer">
        <?php
        if (sizeof($playlist->getEntries())) {
            print '<a href="./video.php?v=' . $playlist->getEntries()[0]->getAlias() . '&p=' . $playlist->getId() . '">' . Locale::getValue('playlist.play') . '</a>';
        }
        ?>
    </div>
</div>