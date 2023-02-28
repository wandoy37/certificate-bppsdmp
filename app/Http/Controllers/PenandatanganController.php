<?php

namespace App\Http\Controllers;

use App\Models\Penandatangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenandatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penandatangans = Penandatangan::latest()->paginate(10);
        return view('auth.penandatangan.index', compact('penandatangans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.penandatangan.create');
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
                'nip' => 'required',
                'pangkat_golongan' => 'required',
                'jabatan' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            Penandatangan::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'nip' => $request->nip,
                'pangkat_golongan' => $request->pangkat_golongan,
                'jabatan' => $request->jabatan,
            ]);

            return redirect()->route('dashboard.penandatangan.index')->with('success', 'Penandatangan has ben added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.penandatangan.index')->with('fail', 'Penandatangan fail added');
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
    public function show($slug)
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
        $penandatangan = Penandatangan::where('slug', $slug)->first();
        return view('auth.penandatangan.edit', compact('penandatangan'));
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
                'nip' => 'required',
                'pangkat_golongan' => 'required',
                'jabatan' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $penandatangan = Penandatangan::where('slug', $slug)->first();
            $penandatangan->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'nip' => $request->nip,
                'pangkat_golongan' => $request->pangkat_golongan,
                'jabatan' => $request->jabatan,
            ]);

            return redirect()->route('dashboard.penandatangan.index')->with('success', 'Penandatangan has ben updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.penandatangan.index')->with('fail', 'Penandatangan fail updated');
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
        DB::beginTransaction();
        try {
            $penandatangan = Penandatangan::where('slug', $slug)->first();
            $penandatangan->delete($penandatangan);
            return redirect()->route('dashboard.penandatangan.index')->with('success', 'Penandatangan has ben delete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.penandatangan.index')->with('fail', 'Penandatangan fail delete');
        } finally {
            DB::commit();
        }
    }
}
