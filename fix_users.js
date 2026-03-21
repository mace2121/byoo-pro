import { Client } from 'ssh2';

const conn = new Client();
conn.on('ready', () => {
    const cmd = `cd /var/www/byoo/app && git pull origin main && php artisan tinker --execute="\\App\\Models\\User::doesntHave('profile')->get()->each(function (\\$u) { \\$u->profile()->create(['username' => \\$u->username]); \\$p = \\App\\Models\\Plan::where('slug', 'free')->first(); if (\\$p && !\\$u->subscription) { \\App\\Models\\Subscription::create(['user_id' => \\$u->id, 'plan_id' => \\$p->id, 'status' => 'active', 'starts_at' => now()]); } });"`;
    
    conn.exec(cmd, (err, stream) => {
        if (err) throw err;
        stream.on('close', () => {
            conn.end();
            console.log('Done!');
        }).on('data', (d) => console.log(d.toString()))
          .stderr.on('data', (d) => console.log('ERR: ' + d.toString()));
    });
}).on('error', console.error).connect({
    host: '168.231.125.93', port: 22, username: 'root', password: 'Mahsum.2121+'
});
