<div class="menu-wrapper">
    <div class="menu">
        <a href="./" class="<?= str_ends_with($_SERVER['URL'], 'index.php') ? "selected" : "" ?>"><?= Locale::getValue('page.main') ?></a>
        <a href="./profile.php" class="<?= str_ends_with($_SERVER['URL'], 'profile.php') ? "selected" : "" ?>"><?= Locale::getValue('page.profile') ?></a>
        <a href="./video.php" class="<?= str_ends_with($_SERVER['URL'], 'video.php') ? "selected" : "" ?>"><?= Locale::getValue('page.video') ?></a>
        <a href="./playlist.php" class="<?= str_ends_with($_SERVER['URL'], 'playlist.php') ? "selected" : "" ?>"><?= Locale::getValue('page.playlists') ?></a>
    </div>
</div>