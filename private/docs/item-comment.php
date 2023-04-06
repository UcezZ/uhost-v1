<div id="comment<?= $comment->getId() ?>" class="item-comment-wrapper">
    <div class="comment-header-wrapper">
        <div class="username-wrapper">
            <a class="username" href="./profile.php?u=<?= $comment->getUserId() ?>"><?= $comment->getUser()->getName() ?></a>
            <span class="datetime"><?= $comment->getHumanTime() ?></span>
        </div>
        <?php
        if (isset($currentuser) && ((($v = $comment->getVideo()) && $v->getUserId() == $currentuser->getId()) || $comment->getUserId() == $currentuser->getId() || $currentuser->isAdmin())) {
            print('<div id="delete' . $comment->getId() . '" class="delete-wrapper">
                    <span></span>
                    <span></span>
                </div>');
        }
        ?>
    </div>
    <div class="comment-body">
        <span><?= $comment->getText() ?></span>
    </div>
</div>