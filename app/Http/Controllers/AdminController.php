<?php

namespace App\Http\Controllers;

use App\Models\ClickLog;
use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use App\Models\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $pro_users = User::where('plan', 'pro')->count();
        $free_users = User::where('plan', 'free')->count();
        $monthly_revenue = $pro_users * 5;

        $total_links = Link::count();
        $total_clicks = ClickLog::count();
        $total_views = ViewLog::count();

        $recent_users = User::latest()->take(5)->get();

        $popular_profiles = Profile::with('user')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total_users',
            'pro_users',
            'free_users',
            'monthly_revenue',
            'total_links',
            'total_clicks',
            'total_views',
            'recent_users',
            'popular_profiles'
        ));
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $blocksEnabled = Schema::hasTable('blocks');

        $users = User::with(['profile', 'links'])
            ->withCount($blocksEnabled ? ['links', 'blocks'] : ['links'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'blocksEnabled'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kendinizi pasif yapamazsiniz.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $status = $user->is_active ? 'aktif edildi' : 'pasif edildi';

        return back()->with('success', "Kullanici {$user->username} basariyla {$status}.");
    }

    public function toggleVerified(User $user)
    {
        $user->verified = ! $user->verified;
        $user->save();

        $status = $user->verified ? 'dogrulandi' : 'dogrulama rozeti kaldirildi';

        return back()->with('success', "Kullanici {$user->username} icin durum guncellendi: {$status}.");
    }

    public function updatePlan(Request $request, User $user)
    {
        $request->validate([
            'plan' => 'required|in:free,pro'
        ]);

        $user->plan = $request->plan;
        
        if ($request->plan === 'pro') {
            $user->plan_expire_date = now()->addMonths(1);
        } else {
            $user->plan_expire_date = null;
        }
        
        $user->save();

        return back()->with('success', "Kullanici {$user->username} plani " . strtoupper($request->plan) . " olarak guncellendi.");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kendinizi silemezsiniz.');
        }

        if ($user->is_admin) {
            return back()->with('error', 'Baska bir admin hesabi panelden silinemez.');
        }

        $username = $user->username;
        $user->delete();

        return back()->with('success', "Kullanici {$username} silindi.");
    }

    public function impersonate(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Zaten bu kullanici ile giris yapmissiniz.');
        }

        session(['impersonator_id' => Auth::id()]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "{$user->name} olarak giris yaptiniz.");
    }

    public function stopImpersonating()
    {
        if (! session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = session()->pull('impersonator_id');
        $admin = User::findOrFail($adminId);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Admin paneline geri donuldu.');
    }

    public function settings()
    {
        $google_client_id = $this->getEnvValue('GOOGLE_CLIENT_ID');
        $google_client_secret = $this->getEnvValue('GOOGLE_CLIENT_SECRET');
        $google_redirect_uri = $this->getEnvValue('GOOGLE_REDIRECT_URI') ?: '${APP_URL}/auth/google/callback';
        $whatsapp_upgrade_number = $this->getEnvValue('WHATSAPP_UPGRADE_NUMBER');

        return view('admin.settings.index', compact('google_client_id', 'google_client_secret', 'google_redirect_uri', 'whatsapp_upgrade_number'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'google_client_id' => 'nullable|string',
            'google_client_secret' => 'nullable|string',
            'google_redirect_uri' => 'nullable|string',
            'whatsapp_upgrade_number' => 'nullable|string',
        ]);

        $success = $this->setEnvironmentValue([
            'GOOGLE_CLIENT_ID' => $request->google_client_id ?? '',
            'GOOGLE_CLIENT_SECRET' => $request->google_client_secret ?? '',
            'GOOGLE_REDIRECT_URI' => $request->google_redirect_uri ?? '',
            'WHATSAPP_UPGRADE_NUMBER' => $request->whatsapp_upgrade_number ?? '',
        ]);

        if ($success) {
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            return back()->with('success', 'Ayarlar başarıyla güncellendi.');
        } else {
            return back()->with('error', '.env dosyasına yazılamadı. Dosya izinlerini kontrol edin.');
        }
    }

    private function getEnvValue($key)
    {
        $envFile = app()->environmentFilePath();
        if (file_exists($envFile)) {
            $str = file_get_contents($envFile);
            if (preg_match('/^' . preg_quote($key, '/') . '=(.*)$/m', $str, $matches)) {
                return trim($matches[1], '"\' ');
            }
        }
        return '';
    }

    private function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        if (!file_exists($envFile)) {
            return false;
        }

        $str = file_get_contents($envFile);
        $str .= "\n"; // Ensure file ends with newline for easier parsing

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $envValue = (string) $envValue;
                // Determine if we need to quote the value
                // Use double quotes if there are spaces or special characters
                if (preg_match('/\s/', $envValue) || strpos($envValue, '${') !== false || strpos($envValue, '#') !== false) {
                    $parsedValue = '"' . trim($envValue, '"\'') . '"';
                } else {
                    $parsedValue = trim($envValue, '"\'');
                }

                $keyPosition = mb_strpos($str, "{$envKey}=");
                
                if ($keyPosition !== false) {
                    $endOfLinePosition = mb_strpos($str, "\n", $keyPosition);
                    $oldLine = mb_substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    
                    // Replace the old line completely
                    $str = str_replace($oldLine, "{$envKey}={$parsedValue}", $str);
                } else {
                    // Key doesn't exist, append it
                    $str .= "{$envKey}={$parsedValue}\n";
                }
            }
        }

        $str = trim($str); // Remove trailing newlines

        if (file_put_contents($envFile, $str) !== false) {
            return true;
        }

        return false;
    }
}
