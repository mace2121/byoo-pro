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
}
