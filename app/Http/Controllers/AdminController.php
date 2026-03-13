<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClickLog;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_links = Link::count();
        $total_clicks = ClickLog::count();

        return view('admin.dashboard', compact('total_users', 'total_links', 'total_clicks'));
    }

    public function users()
    {
        // Fetch users with their profiles, paginate
        $users = User::with('profile')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        // Prevent disabling self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kendinizi pasif yapamazsınız.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'Aktif edildi' : 'Pasif edildi';
        return back()->with('success', "Kullanıcı {$user->username} başarıyla {$status}.");
    }
}
