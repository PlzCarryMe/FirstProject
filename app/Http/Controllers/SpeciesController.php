<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Species;
use App\Petnames;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $species = Species::select('id','name')->get();
        return view('species.index')->with('species',$species);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petnames = Petnames::select('name')->get();
        return view('species.create')->with('petnames', $petnames);
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

      if(Species::create($data)){
         Session::flash('message', 'Added Successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('species');
      }else{
         Session::flash('message', 'Data not saved!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('species');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $species =Species::find($id);
        return view('species.edit')->with('species', $species);
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

      $select = Species::find($id);

      if($select->update($data)){

         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('species');
      }else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('species');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //$select = Species::find($id);
    //$role->users()->sync([]);
    Species::destroy($id);

      Session::flash('message', 'Delete successfully!');
      Session::flash('alert-class', 'alert-success');

      return redirect()->route('species');
    }


    public function allspecies(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'species',
            2 =>'petnames',
            3 => 'actions',
        );

        $totalData = Species::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $species = Species::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value');

            $species =  Species::where('name','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Species::where('name','LIKE',"%{$search}%")
                             //->orWhere('user', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();

        foreach ($species as $species)
        {
            $edit =  route('species.edit',$species->id);
            $delete =  route('species.delete',$species->id);

            $nestedData['id'] = $species->id;
            $nestedData['species'] = $species->name;

            $test = [];
            foreach ($species->pets as $pet){
                $test[] =  $pet->petnames->name;
            }
            $nestedData['petnames'] = $test;

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
