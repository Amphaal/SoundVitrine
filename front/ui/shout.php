<div id='shoutContainer' style='max-height:0'>
    <div id='shoutNotification'>
        Now Playing...
    </div>
    <div id='shoutNotificationOut'>
        <i class="fas fa-forward"></i>
    </div>
    <div class='shout'>
        <a title='Play on Youtube' target='_blank'>
            <div class='imgLoader cover'>
                <img onload="imgLoaded(event)" onerror="brokenImg(event)"/>
                <i class="fab fa-youtube"></i>
            </div>
        </a>
        <div class='albumDesc'>
            <div>
                <div class='name'></div>
                <div class='meta'></div>
            </div>
        </div>
        <div class='timeline'></div>
        <label class='mute'>
            <input id='muzzleShout' type='checkbox' onclick="toggleShoutSound(event)">
            <i class="fas fa-bell" title='Play sound on new music'></i>
        </label>
    </div>
</div>