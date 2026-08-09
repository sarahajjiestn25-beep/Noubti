<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role','service'])
            ->latest()
            ->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $services = Service::all();

        return view('superadmin.users.create', compact('roles','services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required|max:100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
            'id_role'=>'required|exists:roles,id_role',
            'id_service'=>'nullable|exists:services,id_service',
            'telephone'=>'nullable|max:20',
        ]);

        User::create([
            'nom'=>$request->nom,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'telephone'=>$request->telephone,
            'id_role'=>$request->id_role,
            'id_service'=>$request->id_service,
            'actif'=>1,
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success','Utilisateur ajouté avec succès.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $services = Service::all();

        return view('superadmin.users.edit', compact(
            'user',
            'roles',
            'services'
        ));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom'=>'required|max:100',
            'email'=>'required|email|unique:users,email,'.$user->id_user.',id_user',
            'id_role'=>'required|exists:roles,id_role',
            'id_service'=>'nullable|exists:services,id_service',
            'telephone'=>'nullable|max:20',
        ]);

        $user->nom=$request->nom;
        $user->email=$request->email;
        $user->telephone=$request->telephone;
        $user->id_role=$request->id_role;
        $user->id_service=$request->id_service;

        if($request->filled('password')){
            $user->password=Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('superadmin.users.index')
            ->with('success','Utilisateur modifié.');
    }

    public function destroy(User $user)
    {
        if(auth()->id()==$user->id_user){
            return back()->with('error','Impossible de supprimer votre compte.');
        }

        $user->delete();

        return back()->with('success','Utilisateur supprimé.');
    }
}