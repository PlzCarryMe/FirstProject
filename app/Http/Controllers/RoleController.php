<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::select('id','description')->get();
        return view('role.index')->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
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

      $validator = Validator::make($request->all(), [
         'description' => 'required|string',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      if(Roles::create($data)){
         Session::flash('message', 'Added Successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('role');
      }else{
         Session::flash('message', 'Data not saved!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $role =Roles::find($id);
      return view('role.edit')->with('role', $role);
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
         'description' => 'required',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }


      $subject = Roles::find($id);

      if($subject->update($data)){

         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('role');
      }else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route('role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $role = Roles::find($id);
      $role->users()->sync([]);
      Roles::destroy($id);

      Session::flash('message', 'Delete successfully!');
      Session::flash('alert-class', 'alert-success');

      return redirect()->route('role');
    }


    //Datatables
    public function allroles(Request $request){
        //sama dengan kolom dari blade js
        $columns = array(
            0 =>'description',
            1 =>'user',
            2 =>'actions',
        );

        // get param <-- ini fix g usa di rubah"
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        $draw = $request->input('draw');

        $data = Roles::select('id','description');

        $totalData = $data->count();
        $totalFiltered = $totalData;

        if (isset($search)) {
            //mengikuti apa yang bisa d cari
            $data->orWhere('description', 'LIKE',"%{$search}%");
            $totalFiltered = $data->count();
        }

        $data = $data->offset($start)
        ->limit($limit)
        ->get();

        $array = [];
        foreach($data as $role){

            $nestedData['description'] = $role->description;

            $test = [];
            foreach ($role->users as $user){
                $test[] =  $user->name;
            }
            $nestedData['user'] = $test;

            $edit =  route('role.edit',$role->id);
            $delete =  route('role.delete',$role->id);
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

        //dd($array);

        // ini juga fix
        return json_encode($json_data);
    }

    // public function allroles(Request $request)
    // {
    //     $columns = array(
    //         0 =>'description',
    //         1 =>'user',
    //         2 => 'actions',
    //     );

    //     $totalData = Roles::count();

    //     $totalFiltered = $totalData;

    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');

    //     if(empty($request->input('search.value')))
    //     {
    //         $roles = Roles::offset($start)
    //                      ->limit($limit)
    //                      ->orderBy($order,$dir)
    //                      ->get();
    //     }
    //     else {
    //         $search = $request->input('search.value');

    //         $roles =  Roles::where('description','LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy($order,$dir)
    //                         ->get();

    //         $totalFiltered = Roles::where('description','LIKE',"%{$search}%")
    //                          //->orWhere('user', 'LIKE',"%{$search}%")
    //                          ->count();
    //     }

    //     $data = array();

    //     foreach ($roles as $role)
    //     {
    //         $edit =  route('role.edit',$role->id);
    //         $delete =  route('role.delete',$role->id);

    //         $nestedData['description'] = $role->description;

    //         foreach ($role->users as $user){
    //             $nestedData['user'] =  $user->name;
    //         }

    //         $nestedData['actions'] = "<a href='{$edit}' class='btn btn-sm btn-info'>Edit</a>
    //                                   <a href='{$delete}' class='btn btn-sm btn-danger'>Delete</a>";

    //         $data[] = $nestedData;

    //     }


    //     $json_data = array(
    //                 "draw"            => intval($request->input('draw')),
    //                 "recordsTotal"    => intval($totalData),
    //                 "recordsFiltered" => intval($totalFiltered),
    //                 "data"            => $data,
    //                 );

    //     return json_encode($json_data);

    // }



}
