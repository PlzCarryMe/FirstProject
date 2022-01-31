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
}
