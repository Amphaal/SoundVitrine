<h1><?php echo i18n("e_log_connect")?></h1>
<?php mayDisplayPopup($login_result); ?>
<form method="POST" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
    <?php echo renderMagnifikInput(
        array(
        "name" => "username",
        "placeholder" => "e_log_username",
        "autocomplete" => "username",
        "required" => true
        )
    )?>
    <?php echo renderMagnifikInput(
        array(
        "type" => "password",
        "placeholder" => "userPwd",
        "autocomplete" => "current-password",
        "required" => true
        )
    )?>
    <input 
        class="hype"
        type="submit" 
        value="✓ <?php echo i18n("validate")?>"
        title="<?php echo i18n("e_log_connect")?>"
    />
</form>
