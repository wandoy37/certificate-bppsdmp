<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = Certificate::latest()->paginate(10);
        return view('auth.certificate.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainings = Training::latest()->get();
        $participants = Participant::latest()->get();
        return view('auth.certificate.create', compact('trainings', 'participants'));
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
                'training' => 'required',
                'participant' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // Last data
            $lastCertificate = Certificate::all()->count();
            $lastCertificate++;

            Certificate::create([
                'code' => str_pad($lastCertificate, 4, '0', STR_PAD_LEFT),
                'training_id' => $request->training,
                'participant_id' => $request->participant,
            ]);
            return redirect()->route('dashboard.certificate.index')->with('success', 'Berhasil menambahkan sertifikat');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.certificate.index')->with('fails', 'Gagal menambahkan sertifikat');
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
    public function edit($code)
    {
        $certificate = Certificate::where('code', $code)->first();
        $trainings = Training::latest()->get();
        $participants = Participant::latest()->get();
        return view('auth.certificate.edit', compact('certificate', 'trainings', 'participants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        // Validator
        $validator = Validator::make(
            $request->all(),
            [
                'training' => 'required',
                'participant' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $certificate = Certificate::where('code', $code)->first();

            $certificate->update([
                'training_id' => $request->training,
                'participant_id' => $request->participant,
            ]);
            return redirect()->route('dashboard.certificate.index')->with('success', 'Update sertifikat berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.certificate.index')->with('fails', 'Update sertifikat gagal');
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
    public function destroy($code)
    {
        DB::beginTransaction();
        try {
            $certificate = Certificate::where('code', $code)->first();
            $certificate->delete($certificate);
            return redirect()->route('dashboard.certificate.index')->with('success', 'Delete sertifikat berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.certificate.index')->with('fails', 'Delete sertifikat gagal');
        } finally {
            DB::commit();
        }
    }
}
