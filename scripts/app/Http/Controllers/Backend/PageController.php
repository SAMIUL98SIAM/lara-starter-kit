<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.pages.index');
        $data['pages'] = Page::latest('id')->get();
        return view('backend.pages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.pages.create');
        return view('backend.pages.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Gate::authorize('app.pages.create');
        $this->validate($request,[
            'title' => 'required|string',
            'slug' => 'required|string|unique:pages',
            'body' => 'required|string',
            'image' => 'nullable|image'
        ]);

        //Store Data

        $page = Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'status' => $request->filled('status'),
        ]);

        //upload image
        $file = $request->file('image');
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(('uploads/page_images'),$filename);
        $page['image'] = $filename;
        $page->save();

        notify()->success('Page Successfully Added.', 'Added');
        return redirect()->route('app.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        Gate::authorize('app.pages.edit');
        return view('backend.pages.form', compact('page'));
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
        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'status' => $request->filled('status'),
        ]);

        $file = $request->file('image');
        @unlink('uploads/page_images'.$page->image);
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(('uploads/page_images'),$filename);
        $page['image'] = $filename;
        $page->save();

        notify()->success('Page Successfully Update.', 'Updated');
        return redirect()->route('app.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        Gate::authorize('app.pages.destroy');
        $page->delete();
        notify()->success('Page Successfully Deleted.', 'Deleted');
        return back();
    }
}
