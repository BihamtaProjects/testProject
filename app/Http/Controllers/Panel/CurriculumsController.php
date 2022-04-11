<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Covent;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($covent)
    {
        $curriculums = Curriculum::where('covent_id',$covent)->get();
        return view('panel.curriculums.index',compact('curriculums','covent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($covent)
    {
        return view('panel.curriculums.create',compact('covent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'partnum' => 'required|integer',
            'active' => 'required',
        ]);
        $input = $request->except('_token');
        Curriculum::create($input);
        $covent = Covent::where('id',$request->input('covent_id'))->first();
        return redirect()->route('curriculums.index',$covent)
            ->with('success','سرفصل مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Curriculum $curriculum)
    {
        return view('panel.curriculums.show',compact('curriculum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curriculum $curriculum)
    {

        $request->validate([
            'title' => 'required|string',
            'partnum' => 'required|integer',
            'active' => 'required',
        ]);
        $input = $request->input();
        $covent = Covent::where('id',$request->input('covent_id'))->first();
        $curriculum->fill($input)->save();
        return redirect()->route('curriculums.index',$covent)
            ->with('success','سرفصل مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curriculum  $curriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curriculum $curriculum)
    {
        $covent = Covent::where('id',$curriculum->covent_id)->first();
        $curriculum->delete();
        return redirect()->route('curriculums.index',$covent)
            ->with('warning','سرفصل مورد نظر با موفقیت حذف شد. ');
    }
}
