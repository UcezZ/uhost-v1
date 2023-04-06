<div class="action-wrapper form-editor-wrapper">
    <form class="editor video" method="POST" action="./video-edit.php">
        <input type="hidden" name="v" value="<?= $video->getAlias() ?>" />
        <input style="display: none" type="checkbox" id="vec" required />
        <table class="editor">
            <tr>
                <td colspan="2"><?= Locale::getValue('video.edit') ?></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('common.caption') ?></td>
                <td><input type="text" name="name" id="vn" maxlength="255" value="<?= $video->getName() ?>" required>
                </td>
            </tr>
            <tr>
                <td><?= Locale::getValue('video.ispublic') ?></td>
                <td class="toggle-wrapper">
                    <input id="vp" name="pub" type="checkbox" <?= $video->getIsPublic() ? 'checked' : '' ?> />
                    <label for="vp">
                        <span></span>
                    </label>
                </td>
            </tr>
        </table>
        <button type="submit">
            <img src="./media/icons/edit.svg">
        </button>
    </form>
    <script id="ves">
        let
            c = document.getElementById('vec'),
            p = document.getElementById('vp'),
            n = document.getElementById('vn'),
            s = document.getElementById('ves'),
            e = function() {
                if (!c.checked) {
                    c.checked = true;
                }
            };
        p.addEventListener('change', e);

        n.addEventListener('change', e);
        n.attributes.removeNamedItem('id');

        s.outerHTML = '';
    </script>
</div>
<div class="action-wrapper delete-wrapper">
    <form class="delete" method="POST" action="./video-remove.php">
        <input type="hidden" name="v" value="<?= $video->getAlias() ?>" />
        <span class="centerer-wrapper"><?= Locale::getValue('delete.confirm') ?></span>
        <div class="centerer-wrapper toggle-wrapper">
            <input id="checkbox<?= $video->getAlias() ?>" type="checkbox" required />
            <label for="checkbox<?= $video->getAlias() ?>">
                <span></span>
            </label>
        </div>
        <button type="submit">
            <img src="./media/icons/delete.svg">
        </button>
    </form>
</div>