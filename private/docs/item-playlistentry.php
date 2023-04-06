<div class="playlist-entry">
    <div class="icon">
        <img src="./video.php?v=<?= $video->getAlias() ?>&q=thumbnail">
    </div>
    <a href="./video.php?v=<?= $video->getAlias() ?>&p=<?= $playlist->getId() ?>" class="name">
        <span><?= $video->getUser()->getName() ?></span>
        <span><?= $video->getName() ?></span>
    </a>
    <div class="duration"><?= $video->getHumanDuration() ?></div>
    <div class="delete-wrapper">
        <form class="delete" method="POST" action="./playlist-remove.php">
            <input type="hidden" name="p" value="<?= $playlist->getId() ?>" />
            <input type="hidden" name="v" value="<?= $video->getAlias() ?>" />
            <span class="centerer-wrapper"><?= Locale::getValue('delete.confirm') ?></span>
            <div class="centerer-wrapper toggle-wrapper">
                <input id="checkbox<?= $video->getAlias() ?>" type="checkbox" required />
                <label for="checkbox<?= $video->getAlias() ?>">
                    <span></span>
                </label>
            </div>
            <button type="submit">
                <img src="./media/icons/delete.svg">
            </button>
        </form>
    </div>
</div>