<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Penandatangan;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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
        // Last data
        $lastCertificate = Certificate::all()->count();
        $lastCertificate++;
        $trainings = Training::latest()->get();
        $participants = Participant::latest()->get();
        $penandatangans = Penandatangan::latest()->get();
        return view('auth.certificate.create', compact('trainings', 'participants', 'lastCertificate', 'penandatangans'));
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
                'penandatangan' => 'required',
                'tanggal_terbit' => 'required',
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

            // Store QRCode
            QrCode::Format('png')->generate(route('show.certificate', str_pad($lastCertificate, 4, '0', STR_PAD_LEFT)), public_path() . '/qrcode/' . str_pad($lastCertificate, 4, '0', STR_PAD_LEFT) . '.' . 'png');

            Certificate::create([
                'code' => str_pad($lastCertificate, 4, '0', STR_PAD_LEFT),
                'training_id' => $request->training,
                'participant_id' => $request->participant,
                'penandatangan_id' => $request->penandatangan,
                'tanggal_terbit' => $request->tanggal_terbit,
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
        $penandatangans = Penandatangan::latest()->get();
        return view('auth.certificate.edit', compact('certificate', 'trainings', 'participants', 'penandatangans'));
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
                'penandatangan' => 'required',
                'tanggal_terbit' => 'required',
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
                'penandatangan_id' => $request->penandatangan,
                'tanggal_terbit' => $request->tanggal_terbit,
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

    public function cetakPelatihan(Request $request, $code)
    {
        // Get data certificate
        $certificate = Certificate::where('code', $code)->first();
        $filePath = public_path("certificates/template_pelatihan.pdf");
        $outputFilePath = public_path("certificates/pelatihan/" . $certificate->code . "." . 'pdf');
        $this->fillPDFFilePelatihan($filePath, $outputFilePath, $certificate);

        return response()->file($outputFilePath);
    }

    public function fillPDFFilePelatihan($file, $outputFilePath, $certificate)
    {
        $fpdi = new FPDI;

        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 10);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 103, 'Nomor : ' . $certificate->training->code . ' / ' . $certificate->code . ' / BPPSDMP / ' . $certificate->training->year, 0, 0, 'C');
            $fpdi->SetX(12.6);

            // Pemprov Desc
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 63);
            $fpdi->SetX(45);
            $fpdi->Cell(0, 10, 'Pemerintah Provinsi Kalimantan Timur berdasarkan Peraturan Mentri Pertanian Republik Indonesia Nomor', 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 69);
            $fpdi->SetX(45);
            $fpdi->Cell(0, 10, '37/PERMENTAN/SM.120/8/2018 tentang Pedoman Pelatihan Pertanian, manyatakan bahwa :', 0, 0, 'L');
            $fpdi->SetX(12.6);

            // Personal participant
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 80);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->name, 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 85.5);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->nip, 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 91.5);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->birth, 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 97.2);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->pangkat_golongan, 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 103.1);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->jabatan, 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 109);
            $fpdi->SetX(150);
            $fpdi->Cell(0, 10, $certificate->participant->instansi, 0, 0, 'L');
            $fpdi->SetX(12.6);

            // Telah Mengikuti
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 128);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, $certificate->training->title . ' yang diselenggarakan', 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 133);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, 'oleh UPTD Balai Penyluhan dan Pengembangan Sumber Daya Manusia Pertanian Provinsi Kalimanan Timur', 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 138);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, 'mulai tanggal ' . $certificate->training->tanggal_pelaksanaan . 'dengan jumlah ' . $certificate->training->hour . 'jam berlatih.', 0, 0, 'C');
            $fpdi->SetX(12.6);

            // QrCode
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 160);
            $fpdi->SetX(45);
            $fpdi->Image(public_path() . '/qrcode/' . $certificate->code . '.png', 47, 155, 20, 0, 'PNG');
            $fpdi->SetX(12.6);

            // Penandatangan
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 145.5);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->tanggal_terbit, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 150);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->jabatan, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "UB", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 170);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->name, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 175);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->pangkat_golongan, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 180);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, 'NIP. ' . $certificate->penandatangan->nip, 0, 0, 'C');
            $fpdi->SetX(12.6);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }

    // BIMTEK
    public function cetakBimtek(Request $request, $code)
    {
        // Get data certificate
        $certificate = Certificate::where('code', $code)->first();

        $filePath = public_path("certificates/template_bimtek.pdf");
        $outputFilePath = public_path("certificates/bimtek/" . $certificate->code . "." . 'pdf');
        $this->fillPDFFileBimtek($filePath, $outputFilePath, $certificate);

        return response()->file($outputFilePath);
    }

    public function fillPDFFileBimtek($file, $outputFilePath, $certificate)
    {
        $fpdi = new FPDI;

        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 10);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 105, 'Nomor : ' . $certificate->training->code . ' / ' . $certificate->code . ' / BPPSDMP / ' . $certificate->training->year, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "B", 20);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 93);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, $certificate->participant->name, 0, 0, 'C');
            $fpdi->SetX(12.6);

            // Text Descriptions
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 120);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, $certificate->training->title, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 127);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, 'diselenggarakan oleh UPTD Balai Penyluhan dan Pengembangan SDM Pertanian Provinsi Kalimantan Timur', 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 134);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, 'Dari tanggal ' . $certificate->training->tanggal_pelaksanaan . ' bertempat di ' . $certificate->training->tempat, 0, 0, 'C');
            $fpdi->SetX(12.6);

            // QrCode
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 160);
            $fpdi->SetX(45);
            $fpdi->Image(public_path() . '/qrcode/' . $certificate->code . '.png', 47, 155, 20, 0, 'PNG');
            $fpdi->SetX(12.6);

            // Penandatangan
            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 145.5);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->tanggal_terbit, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 150);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->jabatan, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "UB", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 170);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->name, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 175);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, $certificate->penandatangan->pangkat_golongan, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 180);
            $fpdi->SetX(170);
            $fpdi->Cell(0, 10, 'NIP. ' . $certificate->penandatangan->nip, 0, 0, 'C');
            $fpdi->SetX(12.6);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }
}
