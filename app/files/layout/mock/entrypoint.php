<!DOCTYPE html>
<html lang="<?=I18nSingleton::getInstance()->getLang() ?>">
    <head>
        <script>
            
            /**
             * @param {string} userToSendEventTo
             */
            const sendEvent = async (userToSendEventTo) => {
                const response = await fetch("<?=$_SERVER["REQUEST_URI"] ?>/send", {
                    method: "POST", 
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({ toUser: userToSendEventTo }),
                });
            }

            /**
             * @param {string} userToSubscribeTo
             */
            const subscribeSSE = (userToSubscribeTo) => {
                const url = new URL(window.location.href);
                url.pathname = "<?=MERCURE_PATH ?>";
                url.searchParams.append("topic", "<?=SHOUT_SSE_TOPIC_URI_TEMPLATE ?>".replace("%s", userToSubscribeTo));
                url.searchParams.append('authorization', <?=json_encode($sub_token) ?>);
                return new EventSource(url);
            }

            //
            //
            //

            document.onreadystatechange = () => {
                const username = "test"
                document.getElementById("send-event").onclick = () => sendEvent(username);
                document.getElementById("subscribe").onclick = () => subscribeSSE(username);
            }
        </script>
    </head>
    <body>
        <button id="send-event">Send Event</button>
        <button id="subscribe">Subscribe</button>
    </body>
</html>