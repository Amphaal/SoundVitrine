<div id='discoverContainer' class='subFrame'>
    <div class='subContent' data-cat='<?php echo __('discover') ?>'>
        <div class="sorter"></div>
        <div class='filterWrapper'>
            <div data-sl='Genres' id='genreUI'></div>
            <div data-sl='<?php echo __("artists") ?>' id='artistUI'></div>
            <div data-sl='Albums' id='albumUI'></div>
        </div>
        <?php require "layout/explorer/components/music_library/parts/albumInfos.php" ?>
    </div>
</div>