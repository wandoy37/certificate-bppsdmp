<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('auth.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed|min:6'
            ],
            [
                'password.required' => 'Password wajib diisi',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password.min' => 'Password minimal 6 huruf',
            ],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'slug' => Str::slug($request->username, '-'),
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email' => '-',
            ]);
            return redirect()->route('dashboard.user.index')->with('success', $request->username . ' berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.user.index')->with('fails', $request->username . ' gagal ditambahkan');
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::where('slug', $slug)->first();
        return view('auth.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'username' => 'required',
                'password' => 'confirmed'
            ],
            [
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user = User::where('slug', $slug)->first();

            // New password
            if (request('password')) {
                $newPassword = Hash::make($request->password);
            }
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'slug' => Str::slug($request->username, '-'),
                'password' => $newPassword ?? $user->password,
                'role' => $request->role,
                'email' => '-',
            ]);
            return redirect()->route('dashboard.user.index')->with('success', $request->username . ' berhasil di update');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.user.index')->with('fails', $request->username . ' gagal di update');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->first();
        DB::beginTransaction();
        try {
            $user->delete($user);
            return redirect()->route('dashboard.user.index')->with('success', $user->username . ' Telah di hapus');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.user.index')->with('fails', $user->username . ' Gagal di hapus');
        } finally {
            DB::commit();
        }
    }
}
