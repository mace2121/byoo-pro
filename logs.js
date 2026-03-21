import { Client } from 'ssh2';

const conn = new Client();
conn.on('ready', () => {
  const cmd = `tail -n 50 /var/www/byoo/app/storage/logs/laravel.log && echo "===== NGINX =====" && tail -n 20 /var/log/nginx/error.log`;
  conn.exec(cmd, (err, stream) => {
    if (err) throw err;
    stream.on('close', (code, signal) => {
      conn.end();
    }).on('data', (data) => {
      console.log(data.toString());
    }).stderr.on('data', (data) => {
      console.log('ERR: ' + data.toString());
    });
  });
}).on('error', (err) => {
    console.error('Connection error:', err);
}).connect({
  host: '168.231.125.93',
  port: 22,
  username: 'root',
  password: 'Mahsum.2121+'
});
