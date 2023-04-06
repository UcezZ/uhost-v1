<div class="card-wrapper success">
    <div class="card">
        <div class="card-header"><?= $successCaption ?></div>
        <div class="card-contents">
            <img class="video-preview" src="./video.php?v=<?= $video->getAlias() ?>&q=thumbnail">
            <span><?= '[' . $video->getHumanDuration() . ']<br>' . htmlspecialchars($video->getName()) ?></span>
        </div>
        <div class="card-footer">
            <a href="./video.php"><?= Locale::getValue('common.back') ?></a>
            <a href="./video.php?v=<?= $video->getAlias() ?>"><?= Locale::getValue('video.play') ?></a>
        </div>
    </div>
</div>