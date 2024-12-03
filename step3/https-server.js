const fs = require('node:fs');
const https = require('node:https');


const options = {
    key: fs.readFileSync('/step3/agent2-key.pem'),
    cert: fs.readFileSync('/step3/agent2-cert.pem'),
  };

  https.createServer(options, (req, res) => {
    res.writeHead(200);
    res.end('hello world\n');
  }).listen(8000); 