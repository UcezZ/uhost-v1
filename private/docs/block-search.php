<div class="search-wrapper">
    <form class="search" method="GET" action="./search.php">
        <div class="search-params">
            <table></table>
        </div>
        <div class="search-main">
            <input type="text" minlength="3" maxlength="30" name="q" placeholder="<?= Locale::getValue('search.placeholder') ?>" value="<?= $_GET['q'] ?? '' ?>" required>
            <input type="submit" value="<?= Locale::getValue('page.search') ?>">
        </div>
    </form>
</div>