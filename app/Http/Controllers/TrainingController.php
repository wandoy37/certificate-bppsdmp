<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::latest()->paginate(10);
        $url = url();
        return view('auth.training.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('auth.training.create', compact('categories'));
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
                'code' => 'required',
                'title' => 'required',
                'batch' => 'required',
                'year' => 'required',
                'hour' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'category' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            Training::create([
                'code' => $request->code,
                'title' => $request->title,
                'slug' => Str::slug($request->title . '-angkatan-' . $request->batch . '-tahun-' . $request->year, '-'),
                'batch' => $request->batch,
                'year' => $request->year,
                'hour' => $request->hour,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'category_id' => $request->category,
            ]);
            return redirect()->route('dashboard.training.index')->with('success', 'Pelatihan has ben added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.training.index')->with('fail', 'Pelatihan fail added');
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
        $training = Training::where('slug', $slug)->first();
        $categories = Category::latest()->get();
        return view('auth.training.edit', compact('training', 'categories'));
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
                'code' => 'required',
                'title' => 'required',
                'batch' => 'required',
                'year' => 'required',
                'hour' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'category' => 'required',
            ],
            [],
        );

        // kondisi jika validasi gagal dilewati.
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $training = Training::where('slug', $slug)->first();
            $training->update([
                'code' => $request->code,
                'title' => $request->title,
                'slug' => Str::slug($request->title . '-angkatan-' . $request->batch . '-tahun-' . $request->year, '-'),
                'batch' => $request->batch,
                'year' => $request->year,
                'hour' => $request->hour,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'category_id' => $request->category,
            ]);
            return redirect()->route('dashboard.training.index')->with('success', 'Pelatihan has ben updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.training.index')->with('fail', 'Pelatihan fail updated');
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
            $training = Training::where('slug', $slug)->first();
            $training->delete($training);
            return redirect()->route('dashboard.training.index')->with('success', 'Training has ben delete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('dashboard.training.index')->with('fail', 'Training fail delete');
        } finally {
            DB::commit();
        }
    }
}
