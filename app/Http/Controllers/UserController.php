<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function user(){
    $user = User::all();
    return view('client.user', ['users' => $user]);
   }

   public function edit($id)
   {
       $user = User::findOrFail($id);
       return view('client.edit', ['user' => $user]);
   }

   public function update(Request $request, $id)
   {
       $user = User::findOrFail($id);
       
       $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|email|max:255|unique:users,email,'.$id,
           'role' => 'required|in:admin,user',
       ]);
       
       $user->name = $request->name;
       $user->email = $request->email;
       $user->role = $request->role;
       
       if($request->filled('password')) {
           $user->password = Hash::make($request->password);
       }
       
       $user->save();
       
       return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
   }

   public function destroy($id)
   {
       $user = User::findOrFail($id);
       $user->delete();
       
       return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
   }
}
