<div id="accountCreation">
    <h1><?php echo __("e_log_createAccount") ?></h1>
    <?php mayDisplayPopup($acr); ?>
    <form class="loginRack" method="POST" autocomplete="off" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
        <?php echo renderMagnifikInput(
            [
            "name" => "username",
            "placeholder" => "e_log_username",
            "required" => true,
            "autocomplete" => "username"
            ],
            $rules
        ) ?>    
        <?php echo renderMagnifikInput(
            [
            "type" => "password",
            "placeholder" => "userPwd",
            "required" => true,
            "autocomplete" => "current-password"
            ],
            $rules
        ) ?>    
        <?php echo renderMagnifikInput(
            [
            "type" => "email",
            "placeholder" => "e_log_email",
            "required" => true
            ]
        ) ?>
        <input
            class="hype"
            type="submit" 
            value="✓ <?php echo __("validate") ?>"
            title="<?php echo __("e_log_createAccount") ?>"
        />
    </form>
</div>