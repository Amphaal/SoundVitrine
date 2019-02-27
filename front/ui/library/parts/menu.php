<div id='banner-side'>
    <label class="clickable" title="<?php echo i18n("users_profile", $user_qs)?>">
        <input id='showProfile' type='checkbox' onclick="toggleProfile(event)" autocomplete="off">
        <?php if($expectedProfilePic) {?>
        <img class='profilepic' src="<?php echo $expectedProfilePic ?>">
        <?php } else {?>
        <i class="fas fa-user"></i>
        <?php } ?>
    </label> 
    <label class="clickable" title="<?php echo i18n("feed")?>">
        <input id='showFeed' type='checkbox' onclick="toggleFeed(event)" autocomplete="off">
        <i class="fas fa-newspaper"></i>
    </label>
    <label class="clickable" title="<?php echo i18n("stats")?>">
        <input id='showStats' type='checkbox' onclick="toggleStats(event)" autocomplete="off">
        <i class="fas fa-chart-pie"></i>
    </label>
    <div class="clickable connect-side">
        <?php include 'front/ui/_components/connect_btn.php' ?>
    </div>
</div>