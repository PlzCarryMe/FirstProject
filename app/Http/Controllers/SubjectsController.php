<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Roles;

class SubjectsController extends Controller {

   public function index(){
       $subjects = User::select('id','name')->get();
       return view('subjects.index')->with('subjects',$subjects);
   }

   public function create(){
      $role = Roles::select('id','description',)->get();
      return view('subjects.create')->with('role',$role);
   }

   public function store(Request $request){
      $data = $request->except('_method','_token','submit');
      //dd($data);

      $validator = Validator::make($request->all(), [
         'name' => 'required|string|min:3',
         'email' => 'required|string',
         'password' => 'required|string',
         'roles' => 'required|min:1',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      $data['password'] = Hash::make($data['password']);

      //dd($data);
      $newdata = User::create($data);

      if($newdata){
        $newdata->roles()->sync($data['roles']);
         Session::flash('message', 'Added Successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('subjects');
      }
      else{
         Session::flash('message', 'Data not saved!');
         Session::flash('alert-class', 'alert-danger');
      }

      return Back();
   }

   public function edit($id){
      $subjects = User::select('id','name')->where('id', '=', $id)->get();
      $roles = Roles::select('id','description',)->get();

      return view('subjects.edit')->with('subjects',$subjects)->with('roles', $roles);
   }

   public function update(Request $request, $id){
      $data = $request->except('_method','_token','submit');

      //dd($data['roles']);

      $validator = Validator::make($request->all(), [
         'name' => 'required|string|min:3',
         'roles' => 'required|min:1',
      ]);

      if ($validator->fails()) {
         return redirect()->Back()->withInput()->withErrors($validator);
      }

      $subject = User::find($id);
      //dd($data['roles']);
      if($subject->update($data)){
        $subject->roles()->sync($data['roles']);
         Session::flash('message', 'Update successfully!');
         Session::flash('alert-class', 'alert-success');
         return redirect()->route('subjects');
      }
      else{
         Session::flash('message', 'Data not updated!');
         Session::flash('alert-class', 'alert-danger');
      }

      return Back()->withInput();
   }

   // Delete
   public function destroy($id){
      $user = User::find($id);
      $user->roles()->sync([]);
      User::destroy($id);

      Session::flash('message', 'Delete successfully!');
      Session::flash('alert-class', 'alert-success');
      return redirect()->route('subjects');
      //return Back();
   }


   public function allusers(Request $request){
        //sama dengan kolom dari blade js
        $columns = array(
            0 =>'name',
            1 =>'roles',
            2 =>'pets',
            3 =>'actions',
        );

        // get param <-- ini fix g usa di rubah"
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        $draw = $request->input('draw');

        $data = User::select('id','name');

        $totalData = $data->count();
        $totalFiltered = $totalData;

        if (isset($search)) {
            //mengikuti apa yang bisa d cari
            $data->orWhere('name', 'LIKE',"%{$search}%");
            $totalFiltered = $data->count();
        }

        $data = $data->offset($start)
        ->limit($limit)
        ->get();

        $array = [];
        foreach($data as $user){
            $counter = 0;
            $nestedData['name'] = $user->name;

            foreach ($user->roles as $role){
                $nestedData['roles'][$counter++] = $role->description;
            }

            foreach ($user->pets as $pet){

            $nestedData['pets'] = [$pet->petnames->name, $pet->species->name, $pet->date_of_birth];

            }

            $edit =  route('subjects.edit',$user->id);
            $delete =  route('subjects.delete',$user->id);
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


}
