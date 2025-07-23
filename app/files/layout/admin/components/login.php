<h1><?=__("e_log_connect") ?></h1>
<?php mayDisplayPopup($login_result); ?>
<form method="POST" action="<?=$_SERVER["REQUEST_URI"] ?>">
    <?=renderMagnifikInput(
        [
        "name" => "username",
        "placeholder" => "e_log_username",
        "autocomplete" => "username",
        "required" => true
        ]
    ) ?>
    <?=renderMagnifikInput(
        [
        "type" => "password",
        "placeholder" => "userPwd",
        "autocomplete" => "current-password",
        "required" => true
        ]
    ) ?>
    <input 
        class="hype"
        type="submit" 
        value="✓ <?=__("validate") ?>"
        title="<?=__("e_log_connect") ?>"
    />
</form>
