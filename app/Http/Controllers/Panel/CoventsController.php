<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Covent;
use App\Models\Faq;
use App\Models\Instructor;
use App\Models\Keyword;
use App\Models\Organizer;
use App\Models\Selectedgroup;
use App\Models\Subject;
use App\Models\Type;
use App\Models\Unit;
use App\Scopes\ActiveCovents;
use App\Traits\convertDateTrait;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class CoventsController extends Controller
{
use convertDateTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isEvent)
    {
           if($isEvent ==0){
               $courses = Covent::where('is_event',0)->withoutglobalScope(ActiveCovents::class)->get();
               return view('panel.courses.index',compact('courses'));
           }elseif($isEvent==1){
               $events = Covent::where('is_event',1)->withoutglobalScope(ActiveCovents::class)->get();
               return view('panel.events.index',compact('events'));
           }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($isEvent)
    {
        $units = Unit::all();
        $organizers = Organizer::all();
        $types = Type::all();
        if($isEvent ==0){
            return view('panel.courses.create',compact('units','organizers','types'));
        }elseif($isEvent==1){
            return view('panel.events.create',compact('units','organizers','types'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $isEvent)
    {
        $request->validate([
            'title' => 'required' ,
            'priority' => 'required' ,
            'summary' => 'required' ,
            'description' => 'required' ,
            'prerequirement' => 'required' ,
            'duration' => 'required' ,
            'organizer_id' => 'required' ,
            'start_time' => 'required' ,
            'type_id' => 'required' ,
            'active' => 'required',
            'unit_id'=>'required'
        ]);
        $input = $request->except('_token','main_pic','main_video');
        $dateTime = $input['start_time'];
        $dateTime = $this->convertTOGeogorian($dateTime);
        $input['start_time'] = $dateTime;
        $input['is_event'] = $isEvent;
        if ($request->hasFile('main_pic')) {
        $input['main_pic'] = \Storage::disk('public')->putFile('main_pic', $request->file('main_pic'));
        }
        if ($request->hasFile('main_video')) {
        $input['main_video'] = \Storage::disk('public')->putFile('main_video', $request->file('main_video'));
        }
        Covent::create($input);
        if($isEvent ==0){
            return redirect()->route('covents.index',$isEvent)
                ->with('success','درس مورد نظر با موفقیت اضافه شد. ');
        }elseif($isEvent==1){
            return redirect()->route('covents.index',$isEvent)
                ->with('success','رویداد مورد نظر با موفقیت اضافه شد. ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Covent  $covent
     * @return \Illuminate\Http\Response
     */
    public function show($isEvent ,$covent)
    {
        $units = Unit::all();
        $organizers = Organizer::all();
        $types= Type::all();
        $instructors = Instructor::all();
        $keywords = Keyword::all();
        $selectedGroups = Selectedgroup::all();
        $subjects = Subject::all();
        $faqs = Faq::all();
        if($isEvent ==0){
$course = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
            return view('panel.courses.show',compact('course','units','organizers','types','instructors','keywords','subjects','selectedGroups','faqs'));
        }elseif($isEvent==1){
            $event = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
            return view('panel.events.show',compact('event','units','organizers','types','instructors','keywords','subjects','selectedGroups','faqs'));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Covent  $covent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $isEvent ,$id )
    {
        $request->validate([
            'title' => 'required' ,
            'priority' => 'required' ,
            'summary' => 'required' ,
            'description' => 'required' ,
            'prerequirement' => 'required' ,
            'duration' => 'required' ,
            'organizer_id' => 'required' ,
            'start_time' => 'required' ,
            'type_id' => 'required' ,
            'active' => 'required',
            'unit_id'=>'required'
        ]);
        $covent= Covent::where('id',$id)->withoutglobalScope(ActiveCovents::class)->first();
        $input = $request->except('_token','main_pic','main_video');
        $input['is_event'] = $isEvent;
        if ($request->hasFile('main_pic')) {
            $input['main_pic'] = \Storage::disk('public')->putFile('main_pic', $request->file('main_pic'));
        }
        if ($request->hasFile('main_video')) {
            $input['main_video'] = \Storage::disk('public')->putFile('main_video', $request->file('main_video'));
        }
        $dateTime = $input['start_time'];
        $dateTime = $this->convertTOGeogorian($dateTime);
        $input['start_time'] = $dateTime;
        $covent->fill($input)->save();
        if($isEvent ==0){
            return redirect()->route('covents.index',$isEvent)
                ->with('success','درس مورد نظر با موفقیت ویرایش شد. ');
        }elseif($isEvent==1){
            return redirect()->route('covents.index',$isEvent)
                ->with('success','رویداد مورد نظر با موفقیت ویرایش شد. ');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Covent  $covent
     * @return \Illuminate\Http\Response
     */
    public function destroy($covent ,$isEvent)
    {
        $covent = Covent::where('id',$covent)->withoutglobalScope(ActiveCovents::class)->first();
        $covent->delete();
        if($isEvent ==0){
            return redirect()->route('covents.index',$isEvent)
                ->with('warning','درس مورد نظر با موفقیت خذف شد. ');
        }elseif($isEvent==1){
            return redirect()->route('covents.index',$isEvent)
                ->with('warning','رویداد مورد نظر با موفقیت خذف شد. ');
        }
    }
}
