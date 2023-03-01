<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Role;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Nette\Utils\Json;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participants = DB::table('participants');
        if (request('search')) {
            $participants->where('name', 'LIKE', '%' . request('search') . '%');
        }

        // Output filter search
        $search = request('search') ?? '';

        $participants = $participants->latest()->paginate(10);

        return view('auth.participant.index', compact('participants', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();
        $trainings = Training::latest()->get();
        return view('auth.participant.create', compact('roles', 'trainings'));
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
                'nik' => 'required',
                'birth' => 'required',
                'pangkat_golongan' => 'required',
                'jabatan' => 'required',
                'instansi' => 'required',
                'email' => 'required',
                'role' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // // Make Dir
            // $file_path = 'certificates';
            // if (!file_exists($file_path)) {
            //     File::makeDirectory($file_path, 0775, true, true);
            // }

            // // Upload and Save File
            // if ($request['document']) {
            //     $file = $request['document'];
            //     $ext = $file->getClientOriginalExtension();
            //     $filename = Str::slug($request->name, '-') . '-' . date('Ymd') . '.' . $ext;
            //     $file->move($file_path, $filename);
            //     $request['document'] = $filename;
            // }

            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-') . '-' . date('Ymd'),
                'nip' => $request->nip,
                'nik' => $request->nik,
                'birth' => $request->birth,
                'pangkat_golongan' => $request->pangkat_golongan,
                'jabatan' => $request->jabatan,
                'instansi' => $request->instansi,
                'email' => $request->email,
                'role_id' => $request->role,
            ];

            Participant::create($data);
            return redirect()->route('dashboard.participant.index')->with('success', 'Peserta has ben added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fails', 'Peserta fail added');
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
        $peserta = Participant::where('slug', $slug)->first();
        // $count = Participant::where('training_id', $peserta->training_id)->count();
        // return response()->json($count);
        return view('auth.participant.print', compact('peserta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $participant = Participant::where('slug', $slug)->first();
        $roles = Role::latest()->get();
        $trainings = Training::latest()->get();
        return view('auth.participant.edit', compact('participant', 'roles', 'trainings'));
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
                'nik' => 'required',
                'birth' => 'required',
                'pangkat_golongan' => 'required',
                'jabatan' => 'required',
                'instansi' => 'required',
                'birth' => 'required',
                'email' => 'required',
                'role' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // Get Participant
            $participant = Participant::where('slug', $slug)->first();

            // // Make Dir
            // $file_path = 'certificates';
            // if (!file_exists($file_path)) {
            //     File::makeDirectory($file_path, 0775, true, true);
            // }

            // // Upload and Save File
            // if ($request['document']) {
            //     // delete old file
            //     $oldFile = $participant->document;
            //     File::delete($file_path, $oldFile);

            //     $file = $request['document'];
            //     $ext = $file->getClientOriginalExtension();
            //     $filename = Str::slug($request->name, '-') . '-' . date('Ymd') . '.' . $ext;
            //     $file->move($file_path, $filename);
            //     $request['document'] = $filename;
            // }

            $participant->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-') . '-' . date('Ymd'),
                'nip' => $request->nip,
                'nik' => $request->nik,
                'birth' => $request->birth,
                'pangkat_golongan' => $request->pangkat_golongan,
                'jabatan' => $request->jabatan,
                'instansi' => $request->instansi,
                'email' => $request->email,
                'role_id' => $request->role,
            ]);
            return redirect()->route('dashboard.participant.index')->with('success', 'Peserta has ben added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fails', 'Peserta fail added');
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
            $participant = Participant::where('slug', $slug)->first();

            // // delete old file
            // $oldFile = $participant->document;
            // $file_path = 'certificates';
            // File::delete($file_path . '/' . $oldFile);

            $participant->delete($participant);
            return redirect()->route('dashboard.participant.index')->with('success', 'participant has ben delete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fail', 'participant fail delete');
        } finally {
            DB::commit();
        }
    }
}
