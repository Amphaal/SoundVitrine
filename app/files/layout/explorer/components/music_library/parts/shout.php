<div id='shoutContainer' class="subFrame">
    <div id='shoutNotification'>
        <?=__("nowPlaying") ?>
    </div>
    <div class='shout'>
        <a title='<?=__("playOnYT") ?>' rel="noopener">
            <div id="shoutImgLoader" class='imgLoader cover'>
                <img onload="imgLoaded(event)" onerror="brokenImg(event)" alt=""/>
                <i class="fab fa-youtube"></i>
            </div>
        </a>
        <div class='albumDesc'>
            <div>
                <div class='name'>PLACEHOLDER</div> <? // we must use placeholder to prevent https://github.com/Amphaal/SoundVitrine/issues/6 ?>
                <div class='meta'>PLACEHOLDER</div> <? // we must use placeholder to prevent https://github.com/Amphaal/SoundVitrine/issues/6 ?>
            </div>
        </div>
        <div class='timeline'></div>
        <label class='mute clickable'>
            <input id='muzzleShout' type='checkbox' onchange="toggleShoutSound(event)" autocomplete="off">
            <i class="fas fa-bell" title-on='<?=__("playSound") ?>' title-off='<?=__("muteNotif") ?>'></i>
        </label>
    </div>
</div>