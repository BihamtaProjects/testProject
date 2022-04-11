<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Covent;
use App\Models\Coventsession;
use App\Models\Unit;
use Illuminate\Http\Request;

class CoventsessionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Covent $covent)
    {
        $unit = $covent->unit;
        $sessions = Coventsession::where('covent_id',$covent->id)->orderby('priority')->get();
        if($sessions->isEmpty()){
            $sessions = Covent::where('id',$covent->id)->get();
        }
        return view('panel.coventsessions.index',compact('sessions','unit','covent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($covent)
    {
        $units = Unit::all();
        return view('panel.coventsessions.create',compact('units','covent'));
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
            'duration' => 'required' ,
            'start_time' => 'required' ,
            'active' => 'required',
            'unit_id'=>'required'
        ]);
        Coventsession::create($request->all());
        $covent = Covent::where('id',$request->input('covent_id'))->first();
        return redirect()->route('coventsessions.index',$covent)
            ->with('success','جلسه مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coventsession  $coventsession
     * @return \Illuminate\Http\Response
     */
    public function show(Coventsession $coventsession)
    {
        $units = Unit::all();
        $session = $coventsession;
        $covent = Covent::where('id',$coventsession->covent_id)->first();
        return view('panel.coventsessions.show',compact('units','session','covent'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coventsession  $coventsession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coventsession $coventsession)
    {
        $request->validate([
            'duration' => 'required' ,
            'start_time' => 'required' ,
            'active' => 'required',
            'unit_id'=>'required'
        ]);
        $input = $request->input();
        $covent = Covent::where('id',$request->input('covent_id'))->first();
        $coventsession->fill($input)->save();
        return redirect()->route('coventsessions.index',$covent)
            ->with('success','جلسه مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coventsession  $coventsession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coventsession $coventsession)
    {
        $covent = Covent::where('id',$coventsession->covent_id)->first();
        $coventsession->delete();
        return redirect()->route('coventsessions.index',$covent)
            ->with('warning','جلسه مورد نظر با موفقیت حذف شد. ');
    }
}
