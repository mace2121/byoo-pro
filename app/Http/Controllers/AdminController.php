<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClickLog;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\ViewLog;
use App\Models\Profile;

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
        
        $users = User::with(['profile', 'links'])
            ->withCount(['links'])
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
        
        return view('admin.users.index', compact('users', 'search'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kendinizi pasif yapamazsınız.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'Aktif edildi' : 'Pasif edildi';
        return back()->with('success', "Kullanıcı {$user->username} başarıyla {$status}.");
    }

    public function impersonate(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kendiniz olarak zaten giriş yapmışsınız.');
        }

        // Store original admin ID in session
        session(['impersonator_id' => Auth::id()]);
        
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "Şu an {$user->name} olarak giriş yaptınız.");
    }

    public function stopImpersonating()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = session()->pull('impersonator_id');
        $admin = User::findOrFail($adminId);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Admin paneline geri döndünüz.');
    }
}
