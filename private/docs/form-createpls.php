<div class="card-wrapper">
    <div class="card">
        <div class="card-header"><?= Locale::getValue('page.createpls') ?></div>
        <form method="POST">
            <table class="card-contents">
                <tr>
                    <td><?= Locale::getValue('common.caption') ?></td>
                    <td><input id="name" type="text" name="name" required minlength="2" maxlength="255" value="<?= $_POST['name'] ?? '' ?>" /></td>
                </tr>
            </table>
            <div class="submit-wrapper">
                <button type="submit"><?= Locale::getValue('common.create') ?></button>
            </div>
        </form>
    </div>
</div>