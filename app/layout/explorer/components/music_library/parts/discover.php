<div id='discoverContainer' class='subFrame'>
    <div class='subContent' data-cat='<?= i18n('discover')?>'>
        <div class="sorter"></div>
        <div class='filterWrapper'>
            <div data-sl='Genres' id='genreUI'></div>
            <div data-sl='<?= i18n("artists")?>' id='artistUI'></div>
            <div data-sl='Albums' id='albumUI'></div>
        </div>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/layout/explorer/components/music_library/parts/albumInfos.php" ?>
    </div>
</div>