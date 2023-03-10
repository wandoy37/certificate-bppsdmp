<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Role;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participants = DB::table('participants')
            ->join('roles', 'roles.id', '=', 'participants.role_id')
            ->select([
                'participants.id',
                'participants.name',
                'participants.slug',
                'participants.nik',
                'participants.nip',
                'roles.title AS role',
            ]);
        if (request('search')) {
            $participants->where('name', 'LIKE', '%' . request('search') . '%');
        }

        // Output filter search
        $search = request('search') ?? '';

        $participants = $participants->orderBy('id', 'DESC')->paginate(10);

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
            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-') . '-' . date('Ymd'),
                'nip' => $request->nip ?? '-',
                'nik' => $request->nik ?? '-',
                'birth' => $request->kota . ', ' . Carbon::parse($request->date)->translatedFormat('d F Y') ?? '-',
                'pangkat_golongan' => $request->pangkat_golongan ?? '-',
                'jabatan' => $request->jabatan ?? '-',
                'instansi' => $request->instansi ?? '-',
                'email' => $request->email ?? '-',
                'role_id' => $request->role,
            ];

            Participant::create($data);
            return redirect()->route('dashboard.participant.index')->with('success', 'Peserta berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fails', 'Peserta gagal di tambahkan');
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
            $participant->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-') . '-' . date('Ymd'),
                'nip' => $request->nip ?? '-',
                'nik' => $request->nik ?? '-',
                'birth' => $request->kota . ', ' . Carbon::parse($request->date)->translatedFormat('d F Y') ?? $participant->birth,
                'pangkat_golongan' => $request->pangkat_golongan ?? '-',
                'jabatan' => $request->jabatan ?? '-',
                'instansi' => $request->instansi ?? '-',
                'email' => $request->email ?? '-',
                'role_id' => $request->role ?? '-',
            ]);
            return redirect()->route('dashboard.participant.index')->with('success', 'Peserta telah di update');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fails', 'Peserta gagal di update');
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

            $participant->delete($participant);
            return redirect()->route('dashboard.participant.index')->with('success', 'Peserta telah di hapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.participant.index')->with('fail', 'Peserta gagal di hapus');
        } finally {
            DB::commit();
        }
    }
}
