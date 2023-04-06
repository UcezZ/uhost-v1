<div class="form-editor-wrapper">
    <form class="editor user" method="POST" action="./profile.php">
        <input type="hidden" name="u" value="<?= $user->getId() ?>" />
        <input style="display: none" type="checkbox" id="uec<?= $user->getId() ?>" required />
        <table class="editor">
            <tr>
                <td colspan="2"><?= Locale::getValue('user.edit') ?></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.locale') ?></td>
                <td>
                    <select id="ul<?= $user->getId() ?>" name="locale">
                        <?php
                        foreach (Locale::getSupportedLocales() as $localeKey => $localeName) {
                            print '<option value="' . $localeKey . '"' . ($user->getLocale() == $localeKey ? ' selected' : '') . '>' . $localeName . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.theme') ?></td>
                <td>
                    <select id="ut<?= $user->getId() ?>" name="theme">
                        <?php
                        foreach (Theme::getSupportedThemes() as $themeKey => $themeName) {
                            print '<option value="' . $themeKey . '"' . ($user->getTheme() == $themeKey ? ' selected' : '') . '>' . $themeName . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.name') ?></td>
                <td><input type="text" name="name" id="un<?= $user->getId() ?>" value="<?= $user->getName() ?>"></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.info') ?></td>
                <td><textarea name="info" id="ui<?= $user->getId() ?>"><?= $user->getInfo() ?></textarea></td>
            </tr>
        </table>
        <button type="submit">
            <img src="./media/icons/edit.svg">
        </button>
    </form>
    <script id="ues<?= $user->getId() ?>">
        let
            c = document.getElementById('uec<?= $user->getId() ?>'),
            l = document.getElementById('ul<?= $user->getId() ?>'),
            t = document.getElementById('ut<?= $user->getId() ?>'),
            n = document.getElementById('un<?= $user->getId() ?>'),
            i = document.getElementById('ui<?= $user->getId() ?>'),
            s = document.getElementById('ues<?= $user->getId() ?>'),
            e = function() {
                if (!c.checked) {
                    c.checked = true;
                }
            };
        l.addEventListener('change', e);
        l.attributes.removeNamedItem('id');

        t.addEventListener('change', e);
        t.attributes.removeNamedItem('id');

        n.addEventListener('change', e);
        n.attributes.removeNamedItem('id');

        i.addEventListener('change', e);
        i.attributes.removeNamedItem('id');

        s.outerHTML = '';
    </script>
</div>