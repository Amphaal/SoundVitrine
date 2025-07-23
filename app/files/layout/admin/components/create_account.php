<div id="accountCreation">
    <h1><?=__("e_log_createAccount") ?></h1>
    <?php mayDisplayPopup($acr); ?>
    <form class="loginRack" method="POST" autocomplete="off" action="<?=$_SERVER["REQUEST_URI"] ?>">
        <?=renderMagnifikInput(
            [
            "name" => "username",
            "placeholder" => "e_log_username",
            "required" => true,
            "autocomplete" => "username"
            ],
            $rules
        ) ?>    
        <?=renderMagnifikInput(
            [
            "type" => "password",
            "placeholder" => "userPwd",
            "required" => true,
            "autocomplete" => "current-password"
            ],
            $rules
        ) ?>    
        <?=renderMagnifikInput(
            [
            "type" => "email",
            "placeholder" => "e_log_email",
            "required" => true
            ]
        ) ?>
        <input
            class="hype"
            type="submit" 
            value="✓ <?=__("validate") ?>"
            title="<?=__("e_log_createAccount") ?>"
        />
    </form>
</div>