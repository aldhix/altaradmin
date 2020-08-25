<?php

namespace Aldhix\Altaradmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aldhix\Altaradmin\Models\Admin;
use Hash;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $result = Admin::where("name","like","%{$request->keyword}%")
                        ->orderBy('id','asc')
                        ->paginate(25);
        return view('altar.admin.index',['data'=>$result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('altar.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('admin.index')->with('success','store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        if(Auth::guard('admin')->id() != 1){
            if($admin->id == 1){
                return abort(404);
            }
        }

        return view('altar.admin.edit',['data'=>$admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        if(Auth::guard('admin')->id() != 1){
            if($admin->id == 1){
                return abort(404);
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,'.$admin->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if(!empty($request->password)){
            $query = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ];
        } else {
            $query = [
                'name' => $request['name'],
                'email' => $request['email'],
            ];
        }

        $admin->update($query);
        return redirect()->route('admin.index')->with('success','update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if($admin->id == 1 || Auth::guard('admin')->id == $admin->id){
            return abort(404);
        }

        $admin->delete();
        return redirect()->route('admin.index')->with('success','destroy');
    }
}
