<div class="action-wrapper form-editor-wrapper">
    <form class="editor playlist" method="POST" action="./playlist-add.php">
        <input type="hidden" name="v" value="<?= $video->getAlias() ?>" />
        <table class="editor">
            <tr>
                <td colspan="2"><?= Locale::getValue('playlist.addto') ?></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('playlist.playlist') ?></td>
                <td>
                    <select name="p" required>
                        <option value="" selected><?= Locale::getValue('playlist.choose') ?></option>
                        <?php
                        foreach (Playlist::getAll() as $pls) {
                            print '<option value="' . $pls->getId() . '">' . $pls->getName() . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">
            <img src="./media/icons/playlist.svg">
        </button>
    </form>
</div>