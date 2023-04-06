<?php
if (str_ends_with($_SERVER['URL'], 'profile.php') && isset($_GET['u'])) {
    $user = User::getUser($_GET['u']) ?? $currentuser;
}
?>
<div class="card profile">
    <div class="card-header"><?= $user->getName() ?></div>
    <?php
    if (isset($currentuser) && ($currentuser->isAdmin() || $user->getId() == $currentuser->getId()))
        require __DIR__ . '/form-editor-user.php';
    ?>
    <table class="card-contents">
        <tr>
            <td><?= Locale::getValue('common.id.full') ?></td>
            <td><?= $user->getId() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('auth.login') ?></td>
            <td><?= $user->getLogin() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.role') ?></td>
            <td><?= $roles[$user->getRoleID()] ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.info') ?></td>
            <td><?= strlen($user->getInfo()) ? $user->getInfo() : Locale::getValue('user.info.empty') ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.locale') ?></td>
            <td><?= Locale::getSupportedLocales()[Locale::gatherLocale($user->getLocale())] ?? $user->getLocale() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.theme') ?></td>
            <td><?= Theme::getSupportedThemes()[Theme::gatherTheme($user->getTheme())] ?></td>
        </tr>
        <tr>
            <td>
                <a href="./video.php<?= $user->getId() == $currentuser->getId() ? '' : '?u=' . $user->getId() ?>"> <?= Locale::getValue($user->getId() == $currentuser->getId() ? 'link.myvideos' : 'link.uservideos') ?> </a>
            </td>
            <td><?= Video::count($user) ?></td>
        </tr>
        <tr>
            <td>
                <a href="./playlist.php<?= $user->getId() == $currentuser->getId() ? '' : '?u=' . $user->getId() ?>"><?= Locale::getValue($user->getId() == $currentuser->getId() ? 'link.myplaylists' : 'link.userplaylists') ?></a>
            </td>
            <td><?= Playlist::count($user) ?></td>
        </tr>
    </table>
    <?php
    if ($user->getId() == $currentuser->getId()) {
        print('
    <div class="card-footer">
        <a href="./password.php">' . Locale::getValue('user.changepassword') . '</a>
    </div>');
    }
    ?>
</div>