<div style="display: flex; flex-direction: column; align-items: center">
  <h1><?=__("title_uploadMusicLibrary") ?></h1>
  <form method="POST" autocomplete="off" enctype="multipart/form-data" action="<?=$_SERVER["REQUEST_URI"] ?>">
    <?php /*<input name="MAX_FILE_SIZE" type="hidden"  value="<?=getFileUploadLimit() ?>" autocomplete="off" /> */ ?>
    <input 
      name="<?=constant("MUSIC_LIB_UPLOAD_FILE_NAME") ?>" 
      type="file" 
      value="" 
      accept=".json,.zmlib" 
      required autocomplete="off" 
    />
    <input 
      autocomplete="current-password" 
      name="password" 
      type="password" 
      placeholder="<?=__("userPwd") ?>" 
      required autocomplete="off" 
    /> 
    <input class="hype" type="submit" value="<?=__("sendFile") ?>" autocomplete="off" />
  </form>
  <span style="color: grey; font-size: .8em"><?=__('or') ?></span>
  <br/>
  <a target="_blank" href="<?=constant("COMPANION_APP_GITHUB_LATEST_RELEASE_URL") ?>">
    <button style="padding: .25em .5em" class="hype" value="<?=__("sendFile") ?>">
      <i class="fa-brands fa-github"></i>
      <span><?=__("uploadWithCompanionApp") ?></span>
    </button>
  </a>
</div>