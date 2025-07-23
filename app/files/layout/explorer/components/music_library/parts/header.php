<header>
    <div id='menu'>
        <span class='fctr logo'>
            <div class='content'>
                <span class='upper'>Sound</span>
                <span class='lower'>Vitrine</span>
            </div>
            <span class='cpr_sign'>©</span>
        </span>
        <div id='banner'>
            <div id='banner-desc'>
                <?=__('libraryOfHead', $qs_user) ?>
            </div>
            <?php require "layout/explorer/components/music_library/parts/menu.php" ?>
            <?php require "layout/explorer/components/music_library/parts/searchBand.php" ?>
        </div>
        <?php require "layout/explorer/components/connect_btn.php" ?>
    </div>
    <?php require "layout/explorer/components/music_library/parts/profile.php" ?>
    <?=_wAnim($qs_user) ?>
</header>