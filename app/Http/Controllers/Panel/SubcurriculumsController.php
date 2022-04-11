<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Subcurriculum;
use Illuminate\Http\Request;

class SubcurriculumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Curriculum $curriculum)
    {
        $subcurriculums = Subcurriculum::where('curriculum_id',$curriculum->id)->get();
        return view('panel.subcurriculums.index',compact('subcurriculums','curriculum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Curriculum $curriculum)
    {
        return view('panel.subcurriculums.create',compact('curriculum'));
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
            'title' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'active' => 'required',
            'video_length' => 'integer',
        ]);
        $input = $request->except('_token', 'video_preview');
        if ($request->hasFile('video_preview')) {
            $input['video_preview'] = \Storage::disk('public')->putFile('video_preview', $request->file('video_preview'));
        }
        Subcurriculum::create($input);
        $curriculum = Curriculum::where('id',$input['curriculum_id'])->first();
        return redirect()->route('subcurriculums.index', $curriculum)
            ->with('success', 'برنامه آموزشی مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcurriculum  $subcurriculum
     * @return \Illuminate\Http\Response
     */
    public function show(Subcurriculum $subcurriculum)
    {
        $curriculum = Curriculum::where('id',$subcurriculum->curriculum_id)->first();
        return view('panel.subcurriculums.show',compact('subcurriculum','curriculum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcurriculum  $subcurriculum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcurriculum $subcurriculum)
    {
        $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'active' => 'required',
            'video_length' => 'integer',
        ]);
        $input = $request->except('_token', 'video_preview');
        if ($request->hasFile('video_preview')) {
            $input['video_preview'] = \Storage::disk('public')->putFile('video_preview', $request->file('video_preview'));
        }
        $subcurriculum->fill($input)->save();
        $curriculum = Curriculum::where('id',$input['curriculum_id'])->first();
        return redirect()->route('subcurriculums.index', $curriculum)
            ->with('success', 'برنامه آموزشی مورد نظر با موفقیت ویرایش شد. ');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcurriculum  $subcurriculum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcurriculum $subcurriculum)
    {
        $curriculum = Curriculum::where('id',$subcurriculum->curriculum_id)->first();
        $subcurriculum->delete();
        return redirect()->route('subcurriculums.index',$curriculum)
            ->with('warning','برنامه آموزشی مورد نظر با موفقیت حذف شد. ');
    }
}
