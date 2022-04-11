<?php
/** @noinspection PhpUnused */
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ServiceGroup;
use App\Models\ServicePlan;
use App\Models\ServicePrice;
use Illuminate\Http\Request;
use Lcobucci\JWT\Token\Plain;
use PHPUnit\TextUI\XmlConfiguration\Group;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = ServiceGroup::all();
        return view('panel.services.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required' , 'active' => 'required']);

       ServiceGroup::create($request->all());

        return redirect()->route('services.index')
            ->with('success','سرویس مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = ServiceGroup::where('id',$id)->first();
        return view('panel.services.show',compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'active' => 'required',
        ]);
        $group = ServiceGroup::where('id',$id)->first();

        $input = $request->input();
        $group->fill($input)->save();

        return redirect()->route('services.index')
            ->with('success','سرویس مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = ServiceGroup::where('id',$id)->first();
        $group->delete();
        $groups = ServiceGroup::all();
        return redirect()->route('services.index')
            ->with('warning','سرویس مورد نظر با موفقیت حذف شد. ');
    }

    public function plans($group_id)
    {
        $plans = ServicePlan::where('service_group_id',$group_id)->get();
        return view('panel.services.plans',compact('plans','group_id'));

    }

    public function addPlan($group_id)
    {
        return view('panel.plans.create',compact('group_id'));
    }

    public function storePlan(Request $request,$group_id)
    {

       $data = $request->all();
       $data['service_group_id'] = $group_id;

        ServicePlan::create($data);
        return redirect()->route('services.plans',$group_id)
            ->with('success','پلن مورد نظر با موفقیت اضافه شد. ');


    }

    public function editPlan($plan_id)
    {
        $plan = ServicePlan::where('id',$plan_id)->first();
        $group_id = $plan->service_group_id;
        return view('panel.plans.show',compact('plan','group_id'));
    }

    public function updatePlan(Request $request,$plan_id)
    {
        $input = $request->input();
        $plan = ServicePlan::where('id',$plan_id)->first();
        $plan->fill($input)->save();
        $group_id = $plan->service_group_id;
        return redirect()->route('services.plans',$group_id)
            ->with('success','پلن مورد نظر با موفقیت ویرایش شد. ');
    }

    public function destroyPlan($id)
    {
        $plan = ServicePlan::where('id',$id)->first();
        $plan->delete();
        $group_id = $plan->service_group_id;
        return redirect()->route('services.plans',$group_id)
            ->with('warning','پلن مورد نظر با موفقیت حذف شد. ');
    }

    public function plansPrices($plan_id)
    {
        $prices = ServicePrice::where('service_plan_id',$plan_id)->get();
        return view('panel.services.plansPrices',compact('prices','plan_id'));
    }


//    prices
    public function addPrice($plan_id)
    {
        $plan = ServicePlan::where('id',$plan_id)->first();
        return view('panel.prices.create',compact('plan'));
    }

    public function storePrice(Request $request,$plan_id)
    {

        $data = $request->all();
        $data['service_plan_id'] = $plan_id;
        ServicePrice::create($data);
        return redirect()->route('services.plan.prices',$plan_id)
            ->with('success','پلن مورد نظر با موفقیت اضافه شد. ');

    }

    public function editPrice($price_id)
    {
        $price = ServicePrice::where('id',$price_id)->first();
        $plan_id = $price->service_plan_id;
        return view('panel.prices.show',compact('price','plan_id'));
    }

    public function updatePrice(Request $request,$price_id){

        $input = $request->input();
        $price = ServicePrice::where('id',$price_id)->first();
        $price->fill($input)->save();
        $plan_id = $price->service_plan_id;
        return redirect()->route('services.plan.prices',$plan_id)
            ->with('success','پلن مورد نظر با موفقیت ویرایش شد. ');
    }

    public function destroyPrice($id)
    {
        $plan = ServicePrice::where('id',$id)->first();
        $plan_id = $plan->service_plan_id;
        $plan->delete();
        return redirect()->route('services.plan.prices',$plan_id)
            ->with('warning','پلن مورد نظر با موفقیت حذف شد. ');
    }
}
