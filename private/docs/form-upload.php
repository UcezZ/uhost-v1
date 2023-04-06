<div class="card-wrapper">
    <div class="card">
        <div class="card-header"><?= Locale::getValue('page.upload') ?></div>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="max_file_size" value="2147483647">
            <table class="card-contents">
                <tr>
                    <td><?= Locale::getValue('common.file') ?></td>
                    <td><input id="file" name="file" type="file" accept="video/mp4" value="" required /></td>
                </tr>
                <tr>
                    <td style="white-space: inherit"><?= Locale::getValue('video.ispublic') ?></td>
                    <td class="toggle-wrapper">
                        <input id="checkboxIsPublic" name="pub" type="checkbox" <?= isset($_POST['pub']) && $_POST['pub'] ? 'checked' : '' ?> />
                        <label for="checkboxIsPublic">
                            <span></span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('common.caption') ?></td>
                    <td><input id="name" type="text" name="name" required minlength="2" maxlength="255" value="<?= $_POST['name'] ?? '' ?>" /></td>
                </tr>
            </table>
            <div class="submit-wrapper">
                <button type="submit"><?= Locale::getValue('upload.submit') ?></button>
            </div>
        </form>

        <script src="./js/upload.js"></script>
    </div>
</div>