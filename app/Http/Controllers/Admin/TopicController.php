<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'topics' => Topic::get(),
            'parents' => Topic::whereNull('parent_id')->get()
        ];
        return view('admin.topic.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
            ]);
    
            $imageName = time().'.'.$request->image->extension();
    
            // Public Folder
            $request->image->move(public_path('images'), $imageName);

            $data['image'] = $imageName;
        }

        if($data['parent_id'] == '-1') {
            $data['parent_id'] = null;
        }

        return Topic::insert($data);
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
        $data = $request->except('_method');

        if($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
            ]);
    
            $imageName = time().'.'.$request->image->extension();
    
            // Public Folder
            $request->image->move(public_path('images'), $imageName);

            $data['image'] = $imageName;
        }

        if($data['parent_id'] == '-1') {
            $data['parent_id'] = null;
        }

        return Topic::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Topic::whereId($id)->delete();
    }
}
