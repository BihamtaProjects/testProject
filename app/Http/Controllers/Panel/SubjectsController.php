<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('panel.subjects.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainSubjects = Subject::parent()->get();
        return view('panel.subjects.create',compact('mainSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required' ,
                             'priority' => 'required|numeric',
                             'description' => 'required',
                             'summary' => 'required',

            ]);
        $input = $request->except('_token','image','icon');
        if ($request->hasFile('image')) {
            $input['image'] = \Storage::disk('public')->putFile('image', $request->file('image'));
        }
        if ($request->hasFile('icon')) {
            $input['icon'] = \Storage::disk('public')->putFile('icon', $request->file('icon'));
        }
        Subject::create($input);

        return redirect()->route('subjects.index')
            ->with('success','دسته بندی مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        $mainSubjects = Subject::parent()->get();
        return view('panel.subjects.show',compact('subject','mainSubjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate(['name' => 'required',
            'priority' => 'required|numeric',
            'description' => 'required',
            'summary' => 'required',

        ]);
        $input = $request->except('_token','image','icon');
        if ($request->hasFile('image')) {
            $input['image'] = \Storage::disk('public')->putFile('image', $request->file('image'));
        }
        if ($request->hasFile('icon')) {
            $input['icon'] = \Storage::disk('public')->putFile('icon', $request->file('icon'));
        }
        $subject->fill($input)->save();

        return redirect()->route('subjects.index')
            ->with('success','دسته بندی مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if($subject->parent_id == 0){
            Subject::where('parent_id',$subject->id)->delete();
        }
        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('warning','دسته بندی مورد نظر با موفقیت حذف شد. ');
    }

    public function subSubjects($subject)
    {
        $subjects = Subject::where('parent_id',$subject)->get();
        return view('panel.subjects.subSubjects',compact('subjects'));
    }
}
