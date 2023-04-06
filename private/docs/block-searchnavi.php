<div class="search-wrapper">
    <div class="navi-wrapper">
        <div class="navi-back">
            <?php
            switch ($searchParams->getPage()) {
                case 1:
                    $href = null;
                    break;
                case 2:
                    $href = '';
                    break;
                default:
                    $href = '&p=' . ($searchParams->getPage() - 1);
                    break;
            }
            if (isset($href)) {
                $href .=
                    ($searchParams->getPerPage() != 8 ? '&pp=' . $searchParams->getPerPage() : '') .
                    ($searchParams->getOwn() ? '&own=1' : '');
                print '<a href="./search.php?q=' . $_GET['q'] . $href . '">' . Locale::getValue('search.prevpage') . '</a>';
            }
            ?>
        </div>
        <div class="navi-forward">
            <?php
            if ($searchParams->getPerPage() == sizeof($videoCollection)) {
                $href = '&p=' . ($searchParams->getPage() + 1) .
                    ($searchParams->getPerPage() != 8 ? '&pp=' . $searchParams->getPerPage() : '') .
                    ($searchParams->getOwn() ? '&own=1' : '');
                print '<a href="./search.php?q=' . $_GET['q'] . $href . '">' . Locale::getValue('search.nextpage') . '</a>';
            }
            ?>
        </div>
    </div>
</div>