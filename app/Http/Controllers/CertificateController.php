<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Penandatangan;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Data Certificate
        $certificates = DB::table('certificates')
            ->join('participants', 'participants.id', '=', 'certificates.participant_id')
            ->join('trainings', 'trainings.id', '=', 'certificates.training_id')
            ->join('categories', 'categories.id', '=', 'trainings.category_id')
            ->join('penandatangans', 'penandatangans.id', '=', 'certificates.penandatangan_id')
            ->select(
                'certificates.id',
                'certificates.code',
                'trainings.title AS pelatihan_title',
                'categories.title AS kategori_title',
                'participants.name AS peserta_nama',
            );
        // Get Data Category
        $categories = Category::orderBy('id', 'DESC')->get();
        // Get Data Traininig/Pelatihan
        $trainings = Training::orderBy('id', 'DESC')->get();

        // Method Filters
        if (request('search')) {
            $certificates = $certificates->where(function ($query) {
                $query->where('certificates.code', 'LIKE', '%' . request('search') . '%')
                    ->orWhere('participants.name', 'LIKE', '%' . request('search') . '%')
                    ->orWhere('trainings.title', 'LIKE', '%' . request('search') . '%')
                    ->orWhere('categories.title', 'LIKE', '%' . request('search') . '%');
            });
        }

        if (request('category')) {
            $certificates = $certificates->where('categories.title', 'LIKE', '%' . request('category') . '%');
        }

        if (request('training')) {
            $certificates = $certificates->where('trainings.title', 'LIKE', '%' . request('training') . '%');
        }


        $certificates = $certificates->orderBy('code', 'DESC')->paginate(15);

        return view('auth.certificate.index', compact('certificates', 'categories', 'trainings'));
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
                'code' => 'required|unique:certificates',
                'training' => 'required',
                'participant' => 'required',
                'penandatangan' => 'required',
                'date' => 'required',
            ],
            [
                'code.unique' => 'Code sertifikat telah digunakan',
                'date.required' => 'Tanggal terbit tidak boleh kosong',
                'training.required' => 'Pelatihan tidak boleh kosong',
                'participant.required' => 'Peserta tidak boleh kosong',
                'penandatangan.required' => 'Penandatangan tidak boleh kosong',
            ],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            Certificate::create([
                'code' => $request->code,
                'training_id' => $request->training,
                'participant_id' => $request->participant,
                'penandatangan_id' => $request->penandatangan,
                'tanggal_terbit' => $request->date,
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
            ],
            [
                'code.unique' => 'Code sertifikat telah digunakan',
                'training.required' => 'Pelatihan tidak boleh kosong',
                'participant.required' => 'Peserta tidak boleh kosong',
                'penandatangan.required' => 'Penandatangan tidak boleh kosong',
            ],
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
                'tanggal_terbit' => $request->date,
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
        // Store QRCode
        QrCode::Format('png')->generate(route('show.certificate', $certificate->code), public_path() . '/qrcode/' . $request->code . '.' . 'png');

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
            $fpdi->Cell(0, 10, 'Pemerintah Provinsi Kalimantan Timur berdasarkan Peraturan Menteri Pertanian Republik Indonesia Nomor', 0, 0, 'L');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 69);
            $fpdi->SetX(45);
            $fpdi->Cell(0, 10, '37/PERMENTAN/SM.120/8/2018 tentang Pedoman Pelatihan Pertanian, menyatakan bahwa :', 0, 0, 'L');
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
            $fpdi->Cell(0, 10, 'oleh UPTD Balai Penyuluhan dan Pengembangan Sumber Daya Manusia Pertanian Provinsi Kalimantan Timur', 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 138);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, 'mulai tanggal ' . $certificate->training->tanggal_pelaksanaan . ' dengan jumlah ' . $certificate->training->hour . ' jam berlatih.', 0, 0, 'C');
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

        // Store QRCode
        QrCode::Format('png')->generate(route('show.certificate', $certificate->code), public_path() . '/qrcode/' . $request->code . '.' . 'png');

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

            $fpdi->AddFont("Lobster", "", "Lobster-Regular.php");

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 10);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 105, 'Nomor : ' . $certificate->training->code . ' / ' . $certificate->code . ' / BPPSDMP / ' . $certificate->training->year, 0, 0, 'C');
            $fpdi->SetX(12.6);

            $fpdi->SetFont("Lobster", "", 28);
            $fpdi->SetTextColor(0, 0, 0);
            $fpdi->SetXY(0, 93);
            $fpdi->SetX(10.5);
            $fpdi->Cell(0, 10, Str::headline(strtolower($certificate->participant->name)), 0, 0, 'C');
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
            $fpdi->Cell(0, 10, 'diselenggarakan oleh UPTD Balai Penyuluhan dan Pengembangan SDM Pertanian Provinsi Kalimantan Timur', 0, 0, 'C');
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
