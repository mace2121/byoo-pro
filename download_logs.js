import { Client } from 'ssh2';

const conn = new Client();
conn.on('ready', () => {
    conn.sftp((err, sftp) => {
        if (err) throw err;
        sftp.fastGet('/var/log/nginx/error.log', 'nginx_error.log', (err) => {
            sftp.fastGet('/var/www/byoo/app/storage/logs/laravel.log', 'laravel_remote.log', (err) => {
                conn.end();
                console.log('Logs downloaded.');
            });
        });
    });
}).on('error', console.error).connect({
    host: '168.231.125.93',
    port: 22,
    username: 'root',
    password: 'Mahsum.2121+'
});
