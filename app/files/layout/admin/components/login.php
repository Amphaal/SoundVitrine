<h1><?php echo __("e_log_connect") ?></h1>
<?php mayDisplayPopup($login_result); ?>
<form method="POST" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
    <?php echo renderMagnifikInput(
        [
        "name" => "username",
        "placeholder" => "e_log_username",
        "autocomplete" => "username",
        "required" => true
        ]
    ) ?>
    <?php echo renderMagnifikInput(
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
        value="✓ <?php echo __("validate") ?>"
        title="<?php echo __("e_log_connect") ?>"
    />
</form>
