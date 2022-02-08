<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Pets;
use App\User;
use App\Species;
use App\Petnames;


class PetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = Pets::select('id','date_of_birth','petnames_id','species_id','users_id')->get();
        $species = Species::select('name', 'id')->get();
        return view('pets.index')->with('pets',$pets)->with('species', $species);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $petnames = Petnames::all();
        $species = Species::all();
        return view('pets.create')->with('users', $users)->with('petnames', $petnames)->with('species', $species);
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
         'date_of_birth' => 'required',
         'users_id' => 'required',
         'petnames_id' => 'required',
         'species_id' => 'required',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      if(Pets::create($data)){
         Session::flash('message', 'Added Successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('pets');
      }else{
         Session::flash('message', 'Data not saved!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('pets');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pets = Pets::find($id);
        $species = Species::all();
        $users = User::all();
        $petnames = Petnames::all();
      return view('pets.edit')->with('pets', $pets)->with('species',$species)->with('users',$users)->with('petnames',$petnames);
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
        'date_of_birth' => 'required',
        'users_id' => 'required',
        'petnames_id' => 'required',
        'species_id' => 'required',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      $select = Pets::find($id);

      if($select->update($data)){

         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('pets');
      }else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('pets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pets::destroy($id);

      Session::flash('message', 'Delete successfully!');
      Session::flash('alert-class', 'alert-success');

      return redirect()->route('pets');
    }


    public function allpets(Request $request){
        //sama dengan kolom dari blade js
        $columns = array(
            0 =>'birth',
            1 =>'user',
            2 =>'petname',
            3 =>'species',
            4 =>'actions',
        );

        // get param <-- ini fix g usa di rubah"
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        $draw = $request->input('draw');

        $data = Pets::select('id','date_of_birth','petnames_id','species_id','users_id');

        $totalData = $data->count();
        $totalFiltered = $totalData;

        if (isset($search)) {
            //mengikuti apa yang bisa d cari
            $data->orWhere('date_of_birth', 'LIKE',"%{$search}%");
            $totalFiltered = $data->count();
        }

        $data = $data->offset($start)
        ->limit($limit)
        ->get();

        $array = [];
        foreach($data as $pets){

            $nestedData['birth'] = $pets->date_of_birth;
            $nestedData['user'] = $pets->users->name;
            $nestedData['petname'] = $pets->petnames->name;
            $nestedData['species'] = $pets->species->name;

            // foreach ($role->users as $user){
            //     $nestedData['user'][] = $user->name;
            // }

            $edit =  route('pets.edit',$pets->id);
            $delete =  route('pets.delete',$pets->id);
            $nestedData['actions'] = "<a href='$edit' class='btn btn-sm btn-info'>Edit</a> <a href='$delete' class='btn btn-sm btn-danger'>Delete</a>";


            $array[] = $nestedData;
            //dd($array);

        }
        //dd($data);

        // ini juga fix
        $json_data = [
            'draw' => intval($draw),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $array,
        ];

        // ini juga fix
        return json_encode($json_data);
    }

}
