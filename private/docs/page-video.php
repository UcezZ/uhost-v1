<div class="page-video-wrapper card-wrapper">
    <div class="player-wrapper content-wrapper">
        <div class="video-wrapper">
            <video poster="./video.php?v=<?= $video->getAlias() ?>&q=thumbnail" controls>
                <source src="./video.php?v=<?= $video->getAlias() ?>&q=video" type="video/mp4">
            </video>
        </div>
        <div class="video-footer">
            <div class="video-summary">
                <a class="user" href="./profile.php?u=<?= $video->getUserId() ?>"><?= $video->getUser()->getName() ?></a>
                <div class="name"><?= $video->getName() ?></div>
                <div class="info">
                    <i><?= Locale::getValue('common.posttime') ?>: <?= $video->getHumanTime() ?></i>
                    <i><?= Locale::getValue('video.duration') ?>: <?= $video->getHumanDuration() ?></i>
                </div>
            </div>
            <div class="video-actions">
                <div class="action-wrapper">
                    <a href="./video.php?v=<?= $video->getAlias() ?>&q=download">
                        <img src="./media/icons/download.svg">
                        <span><?= Locale::getValue('common.download') ?></span>
                    </a>
                </div>
                <?php
                if (isset($currentuser)) {
                    require __DIR__ . '/block-videoaddtopls.php';
                }
                if (isset($currentuser) && ($currentuser->isAdmin() || $currentuser->getId() == $video->getUserId())) {
                    require __DIR__ . '/block-videomanage.php';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="queue-wrapper content-wrapper card">
        <div class="card-header"><?= Locale::getValue('video.queue') ?></div>
        <div id="queue-wrapper" class="card-contents card-wrapper"><?= Locale::getValue('queue.loading') ?></div>
    </div>
    <div class="comment-wrapper content-wrapper card">
        <div class="card-header"><?= Locale::getValue('video.comments') ?></div>
        <div id="comment-wrapper" class="card-contents"><?= Locale::getValue('comment.loading') ?></div>
        <?php
        if (isset($currentuser)) {
            print '<div class="card-footer">
            <input id="comment-input" type="text" maxlength="255">
            <input id="comment-submit" type="button" value="' . Locale::getValue('comment.send') . '">
        </div>';
        }
        ?>
    </div>
</div>
<script src="./js/comment.js"></script>
<script src="./js/queue.js"></script>