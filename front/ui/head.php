<div id='head'>
    <div>WTNZ</div>
    <div style="flex-grow:1; display: flex; flex-direction: row; align-items:center">
    <div style='flex-grow:1'>
        <span><?php echo $user_qs ?>'s Library</span> 
        <input id='showStats' type='checkbox' onclick="toggleStats(event)"><label for='showStats'>Stats</label>
    </div>
        <div style='font-size:0.7em'>last update : <?php echo date ("d/m/Y H:i", $latestUpdate)?></div>
    </div>
</div>