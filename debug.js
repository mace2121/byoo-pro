import { Client } from 'ssh2';

const conn = new Client();
conn.on('ready', () => {
  const cmd = `cd /var/www/byoo/app && tail -n 50 storage/logs/laravel.log | grep -v 'stack' | tail -n 2`;
  conn.exec(cmd, (err, stream) => {
    if (err) throw err;
    stream.on('close', (code, signal) => {
      conn.end();
    }).on('data', (data) => {
      console.log('LARAVEL_LOG: ' + data.toString());
    }).stderr.on('data', (data) => {
      console.log('ERR: ' + data.toString());
    });
  });
}).on('error', console.error).connect({
  host: '168.231.125.93',
  port: 22,
  username: 'root',
  password: 'Mahsum.2121+'
});
