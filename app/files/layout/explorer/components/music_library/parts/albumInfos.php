<div id='albumInfos'>
    <div class='aiContent'>
        <div class='hInfos'>
                <label><?php echo __("year") ?><div id="aYear"></div></label>
                <label>Genre<div id="aGenre"></div></label>
                <label><?php echo __("dateAddition") ?><div id="aDateAdded"></div></label>
        </div>
        <div class='hMisc'>
            <div class='imgContainer'>
                <label>Album<div id="aTitle"></div></label>
                <div id='aImage' class='imgLoader' data-no-cover-found="<?php echo __("no_cover_found") ?>"><img onload="imgLoaded(event)" onerror="brokenImg(event)" alt="" /></div>
            </div>
            <label style='margin: 1rem 0 1rem 2rem' ><?php echo __("tracks") ?><ol id="aTracks"></ol></label>
        </div>
        <div class='listen'>
            <a class='animated' rel="noopener">
                <i class="fab fa-youtube"></i>
                <span><?php echo __("listenTTA") ?></span>
            </a>
        </div>
    </div>
    <?php echo _wAnim($qs_user) ?>
</div>