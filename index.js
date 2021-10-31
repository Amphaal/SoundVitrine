import { createServer } from 'https';
import { readFileSync } from 'fs';
import { WebSocketServer } from 'ws';

const server = createServer({
  cert: readFileSync('/path/to/cert.pem'),
  key: readFileSync('/path/to/key.pem')
});
const wss = new WebSocketServer({ server });

const credentialsCheckedStatus = {
	CREDENTIAL_DATA_MISSING: "cdm",
    PASSWORD_OK: "ok",
	EMPTY_USERS_DB: "eud",
    USERNAME_NOT_FOUND: "unfid",
    NO_DB_USERNAME_PASSWORD: "nopass",
    WRONG_PASSWORD: "pmiss"
}

// on socket connected
wss.on('connection', function connection(ws) {

  // handle received messages
  ws.on('message', function incoming(message) {
    // missformated
    if(!message["id"] || !message["r"])
        return;
    
    // depends on request
    switch(message["id"]) {
        case "checkCredentials": {
            // gather data and output template
            let output = {id: "credentialsChecked", r: ""};
            const password = String(message["r"]);
            const path = new URL(this.url).pathname;
            
            // password is empty
            if(!password) {
                output["r"] = credentialsCheckedStatus.CREDENTIAL_DATA_MISSING;
                return this.send(output);
            }

            // parse path to find username
            const username = path.split('/')[0];

            //

            //
            
            // OK
            output["r"] = credentialsCheckedStatus.PASSWORD_OK;
            return this.send(output);

            break;
        }
        default:
            break;
    }
  });

  //

});

server.listen(80);