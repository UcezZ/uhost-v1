<div class="header">
    <?php
    if (isset($currentuser)) {
        require __DIR__ . '/header-burger.htm';
    }
    ?>
    <div class="logo-caption centerer-wrapper">
        <span>
            <a href="./">uHost</a>
        </span>
    </div>
    <?php
    if (isset($currentuser)) {
        require __DIR__ . '/header-menu-wrapper.php';
    }
    ?>
    <div class="auth-block">
        <?php
        if (isset($currentuser)) {
            require __DIR__ . '/header-user-icon.php';
        }
        ?>
        <div class="auth-buttons">
            <?php
            if (isset($currentuser)) {
                $url = './logout.php';
                $caption =  Locale::getValue('page.logout');
                require __DIR__ . '/header-auth-button.php';
            } else {
                if (!str_ends_with($_SERVER['URL'], 'login.php')) {
                    $url = './login.php';
                    $caption = Locale::getValue('page.login');
                    require __DIR__ . '/header-auth-button.php';
                }
                if (!str_ends_with($_SERVER['URL'], 'register.php')) {
                    $url = './register.php';
                    $caption = Locale::getValue('page.register');
                    require __DIR__ . '/header-auth-button.php';
                }
            }
            ?>
        </div>
    </div>
</div>