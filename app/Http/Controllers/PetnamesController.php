<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Petnames;
use App\Species;

class PetnamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petnames = Petnames::select('id','name')->get();
        return view('petnames.index')->with('petnames',$petnames);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $species = Species::select('name','id')->get();
        return view('petnames.create')->with('species',$species);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->except('_method','_token','submit');
      //dd($data);
      $validator = Validator::make($request->all(), [
         'name' => 'required|string',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      if(Petnames::create($data)){
         Session::flash('message', 'Added Successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('petnames');
      }else{
         Session::flash('message', 'Data not saved!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('petnames');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petnames =Petnames::find($id);
        $species = Species::all();
      return view('petnames.edit')->with('petnames', $petnames)->with('species',$species);
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
        $data = $request->except('_method','_token','submit');
        //dd($data);

      $validator = Validator::make($request->all(), [
         'name' => 'required',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }


      $select = Petnames::find($id);

      if($select->update($data)){

         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('petnames');
      }else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('petnames');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    Petnames::destroy($id);

      Session::flash('message', 'Delete successfully!');
      Session::flash('alert-class', 'alert-success');

      return redirect()->route('petnames');
    }

    public function allpetnames(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'species',
            3 => 'actions',
        );

        $totalData = Petnames::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $petnames = Petnames::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value');

            $petnames =  Petnames::where('name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Petnames::where('name','LIKE',"%{$search}%")
                             //->orWhere('user', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();

        foreach ($petnames as $petname)
        {
            $edit =  route('petnames.edit',$petname->id);
            $delete =  route('petnames.delete',$petname->id);

            $nestedData['id'] = $petname->id;
            $nestedData['name'] = $petname->name;

            // $counter = 0;
            // foreach ($petname->pets as $pet){
            //     $nestedData['species'][$counter++] =  $pet->species->name;
            // }

            $test = [];
            foreach ($petname->pets as $pet){
                $test[] =  $pet->species->name;
            }
            $nestedData['species'] = $test;


            $nestedData['actions'] = "<a href='{$edit}' class='btn btn-sm btn-info'>Edit</a>
                                      <a href='{$delete}' class='btn btn-sm btn-danger'>Delete</a>";

            $data[] = $nestedData;

        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data,
                    );

        return json_encode($json_data);
    }
}
