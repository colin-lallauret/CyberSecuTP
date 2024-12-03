import https from 'https';
import fs from 'fs';

const options = {
  key: fs.readFileSync('./selfsigned.key'),
  cert: fs.readFileSync('./selfsigned.crt')
};

https.createServer(options, (_, res) => {
  res.writeHead(200);
  res.end('home page\n');
}).listen(8080, () => {
  console.log('Server is running at https://localhost:8080');
});