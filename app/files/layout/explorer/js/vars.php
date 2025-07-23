<script>
        'use strict';

        var clientURLUnified = <?=json_encode($clientURLUnified) ?>;
        var clientURLShout = <?=json_encode($clientURLShout) ?>;
        
        const ssePathEndpoint = <?=json_encode(constant("MERCURE_PATH")) ?>;
        const sseJwt = <?=json_encode(getSSESubscriberJWT()) ?>;
        const sseShoutTopic = <?=json_encode(getSSETopic_shout($qs_user)) ?>;

        var initialRLoaderUrl = <?=json_encode($initialRLoaderUrl) ?>;

        var _discoverFilter = {
                genreUI : null,
                artistUI : null,
                albumUI : null
        };
        var _discoverMixers = {};

        var defFiltStorageKey = "_discoverSorter";
        var _discoverSorter = localStorage.getItem(defFiltStorageKey) || "count:desc";
        var _defaultSorters = {
                count : "desc", 
                order : "asc"
        };
        var _sortersIconAdapter = {
                order : "alpha",
                count : "amount",
                asc : "up",
                desc : "down" 
        };

        var _appDataFeeds = {};
        var _currentShout = {};
        var _currentShoutDWorth = false;

        var _rLoader = null;
</script>
