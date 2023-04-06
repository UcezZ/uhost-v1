<div class="card-wrapper">
    <div class="card">
        <div class="card-header"><?= Locale::getValue('page.register') ?></div>
        <form class="hscroll" method="POST" enctype="utf8">
            <table class="card-contents">
                <tr>
                    <td><?= Locale::getValue('user.name') ?></td>
                    <td><input name="name" minlength="2" maxlength="64" value="<?= $_POST['name'] ?? '' ?>" required /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('auth.login') ?></td>
                    <td><input name="login" minlength="5" maxlength="64" value="<?= $_POST['login'] ?? '' ?>" required /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('auth.password') ?></td>
                    <td><input type="password" name="password" required /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('auth.confirmpassword') ?></td>
                    <td><input type="password" name="passwordConfirm" required /></td>
                </tr>
            </table>
            <div class="submit-wrapper">
                <button type="submit"><?= Locale::getValue('register.submit') ?></button>
            </div>
        </form>
    </div>
</div>