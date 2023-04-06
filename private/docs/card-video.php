<div class="card video">
    <div class="card-header flex">
        <a class="video-preview" href="./video.php?v=<?= $video->getAlias() ?>">
            <img class="video-preview" src="./video.php?v=<?= $video->getAlias() ?>&q=thumbnail">
            <span><?= $video->getHumanDuration() ?></span>
        </a>
    </div>
    <div class="card-contents">
        <div class="video-summary">
            <div class="user"><?= $video->getUser()->getName() ?></div>
            <div class="name"><?= $video->getName() ?></div>
        </div>
    </div>
</div>