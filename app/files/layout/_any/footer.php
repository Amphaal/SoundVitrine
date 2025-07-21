<?php
    $string = file_get_contents("composer.json");
    $version = json_decode($string)->version;
?>
<footer>
    <div id='credits'>
        <span><?= constant("APP_NAME") ?> 2018-<?= date("Y") ?></span>
        <span>&nbsp;-&nbsp;</span>
        <span style="color:black"><?= $version ?> Beta</span>
        <span>&nbsp;-&nbsp;</span>
        <a href='https://www.linkedin.com/in/guillaumevara/' 
           title="<?= __("devLinkedin") ?>" 
           target="_blank" rel="noopener"
        >
            <img src='/public/images/linkedin.png' alt="<?= __("devLinkedin") ?>"/>
        </a>
    </div>
    <div style="background-color: transparent; font-size: .6em">
        <a href="/account"><i class="fas fa-user-circle" style="margin-right: .25em;"></i><?= __("my_account") ?></a>
    </div>
    <div id="langs">
        <?php

        $curLang = I18nSingleton::getInstance()->getLang();

        foreach (getFilesInFolder('public/images/flags') as $file) {
            $bn = basename($file, ".svg");
            $isCurrentLang = $bn == $curLang;
            ?>
        <form method="POST" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
            <label 
                <?php if (!$isCurrentLang) { ?> 
                    title="<?= __("switch_lang", __("lang_" . $bn));?>" 
                <?php } ?>
                class="<?= !$isCurrentLang ? "clickable unselected" : "" ?>" 
            >   
                <input type="hidden" name="set_lang" value="<?= $bn; ?>" />
                <button <?= $isCurrentLang ? "disabled" : "" ?> style="all:unset; display: flex; align-items: center">
                    <img src="<?= constant("WEB_APP_ROOT") . $file; ?>" />
                </button>
            </label>
        </form>
        <?php } ?>
    </div>
</footer>