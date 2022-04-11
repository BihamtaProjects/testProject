<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages  = Page::all();
        return view('panel.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.pages.create');
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
                'name' => 'required' ,
                'title' => 'required' ,
                'content' => 'required' ,
                'link' => 'required' ,
                'active' => 'required',
        ]);

        $input = $request->except('_token','image');
        if ($request->hasFile('image')) {
            $input['image'] = \Storage::disk('public')->putFile('image', $request->file('image'));
        }
        Page::create($input);
        return redirect()->route('pages.index')
            ->with('success','صفحه مورد نظر با موفقیت اضافه شد. ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('panel.pages.show',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required' ,
            'title' => 'required' ,
            'content' => 'required' ,
            'link' => 'required' ,
            'active' => 'required',
        ]);
        $input = $request->except('_token','image');
        if ($request->hasFile('image')) {
            $input['image'] = \Storage::disk('public')->putFile('image', $request->file('image'));
        }
        $page->fill($input)->save();
        return redirect()->route('pages.index')
            ->with('success','صفحه مورد نظر با موفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')
            ->with('warning','صفحه مورد نظر با موفقیت حذف شد. ');
    }
}
