<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientType;

class ClientTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
    }
    public function index(Request $request){
        $data = ClientType::latest()->paginate(10);

        return view('clienttype.index', compact('data'));
    }
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $url = '';
        if ($request->isMethod('post')) {
           
            $request->validate([
                'title' => 'required',
                'background_color' => 'required',
                'font_color' => 'required'
            ]);

            $input = $request->all();


            $user = ClientType::create($input);
            return redirect('client-type')->with('message', 'Data added Successfully');
        }
        return view('clienttype.create', compact('url'));
    }

    public function view(Request $reques, $id)
    {

        $url = '';
      
        $data = ClientType::find($id);
        return view('clienttype.edit', compact('id', 'url', 'data'));
    }


    public function update(Request $request)
    {

        $input = $request->all();
        $id = $request['id'];
        $data = ClientType::find($id);
        $data->update([
            'title' => $input['title'],
            'background_color' => $input['background_color'],
            'font_color' => $input['font_color']
        ]);

        if ($id) {
            return  redirect()->route('client-type')->with('message', 'Data update Successfully');
        }
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request['id'];
        $skillsEducation = ClientType::find($id);

        if ($skillsEducation) {
            $skillsEducation->delete();
            return response()->json(['status' => 'success']);
        }
    }
}
