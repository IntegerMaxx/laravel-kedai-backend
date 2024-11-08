<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Re   quest;

use Doctrine\DBAL\Logging\Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function __construct()
    // {
    //    // Tambahkan middleware untuk setiap fungsi
    //    $this->middleware('roleCheck:user,admin')->only(['create', 'store']); // User dan Admin bisa menambah
    //    $this->middleware('roleCheck:staff,admin')->only(['edit', 'update']); // Staff dan Admin bisa mengedit
    //    $this->middleware('roleCheck:admin')->only(['destroy']); // Hanya Admin bisa menghapus
    // }

    public function index(Request $request)
    {
        //get users with pagination
        $users = DB::table('user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('pages.user.index', compact('users'));

    }

    public function authenticated(Request $request, $user)
    {
        
        // Mengecek role pengguna
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard'); // Halaman dashboard admin
        }

        if ($user->hasRole('staff')) {
            return redirect()->route('staff.dashboard'); // Halaman dashboard staff
        }

        if ($user->hasRole('user')) {
            return view('user.index'); // Halaman dashboard user
        }

        // Jika role tidak dikenali, redirect ke halaman login dengan error
        return redirect()->route('login')->with('error', 'Role tidak dikenali.');
    }

    //create
    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request, $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'roles' => 'required|in:admin,staff,user',
        ]);

        // if ($user->hasRole('user')) {
        //     return redirect()->route('user.dashboard')->view('user.user.index'); // Halaman dashboard user
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'roles' => $request->roles,
        ]);
        return redirect()->route('user.index')->with('success', 'User created successfully.');

    }
    //show
    public function show($id)
    {
        return view('pages.dashboard');

    }

    //edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    //update
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);

        //check if password is not empty
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        } else {
            //if password is empty, then use the old password
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User updated successfully');

    }
    //destroy
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function userDashboard()
    {
        return view('user.dashboard'); // Tampilkan view khusus user
    }

    public function staffDashboard()
    {
        return view('staff.dashboard'); // Tampilkan view khusus staff
    }

    public function adminDashboard()
    {
        return view('pages.dashboard'); // Tampilkan view khusus admin
    }
}
