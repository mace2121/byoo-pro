import { Client } from 'ssh2';

const conn = new Client();
conn.on('ready', () => {
  const cmd = `systemctl status php8.3-fpm || systemctl status php8.2-fpm`;
  conn.exec(cmd, (err, stream) => {
    if (err) throw err;
    stream.on('close', (code, signal) => {
      conn.end();
    }).on('data', (data) => {
      console.log('STDOUT: ' + data.toString());
    }).stderr.on('data', (data) => {
      console.log('STDERR: ' + data.toString());
    });
  });
}).on('error', console.error).connect({
  host: '168.231.125.93',
  port: 22,
  username: 'root',
  password: 'Mahsum.2121+'
});
