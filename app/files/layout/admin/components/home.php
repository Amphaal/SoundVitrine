<?php
function _btnLink($url, $forceWLocation = false, $XMLR_noBackButton = false)
{
    $out = "";

    if (isXMLHttpRequest() && !$forceWLocation) {
        $out = 'href="' . $url . "\"";
    } else {
        $out = "onclick=\"window.location='" . $url . "'\"";
    }

    if (isXMLHttpRequest() && $XMLR_noBackButton) {
        $out .= " no-back";
    }

    echo $out;
}
?>

<div id="accountManagement">
    <?php if ($iul) {?>
        <div id='EditorWrapper'>
            <?php include "layout/admin/components/parts/bbEditor.php" ?>
            <?php include "layout/admin/components/parts/ppEditor.php" ?>
        </div>
        <div><?php echo __("welcome_back", getCurrentUserLogged()) ?></div>
    <?php } ?>
    <div class="loginRack">
        <?php if ($iul) {?>
            <?php if ($is_not_my_lib) {?>
                <button class="hype" <?php _btnLink($mylib_loc, true) ?>>
                    <i class="fas fa-book"></i>
                    <span><?php echo __("log_accessMyLib") ?></span>
                </button>
            <?php }?>
            <?php /* TODO */ ?>
            <button class="hype" <?php _btnLink("/account/disconnect", false, true) ?>>
                <i class="fas fa-power-off"></i>
                <span><?php echo __("log_disconnect") ?></span>
            </button>
        <?php } else { ?>
            <?php include "layout/admin/components/login.php" ?>
            <hr/>
            <?php /* TODO */ ?>
            <button class="hype" <?php _btnLink("/account/create") ?>>
                <i class="fas fa-user-circle"></i>
                <span><?php echo __("log_createAccount") ?></span>
            </button>
        <?php } ?>
    </div>
    <?php if ($iul) {
        include "layout/admin/components/parts/downloadButtons.php";
    } ?>
</div>
<?php
if ($iul) {
    echo "<style>";

    echo cbacToCss(getCurrentUserLogged(), UserDb::mineProtected()["customColors"]);

    echo "</style>";
}
?>
<script>
    let ppe = new PPEditor("ProfilePicEditor");
    let bbe = new BBEditor("bBandEditor");
</script>