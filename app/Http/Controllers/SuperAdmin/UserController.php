<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->data();
        }
        return view('super-admin.users.index');
    }

    private function data()
    {
        $users = User::with('primaryImage')->get();

        return DataTables::of($users)
            ->addColumn('id', function ($user) {
                return $user->id;
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('action', function ($user) {
                return
                    "<button class='btn btn-info btn_edit' id='btn_edit'  data-user-id='" . $user->id . "'  data-bs-toggle='modal' data-bs-target='#editModal'  > edit</button>" .
                    " <button class='btn btn-danger btn_delete' id='btn_delete'  data-user-id='" . $user->id . "'> delete</button>";
            })

            ->make(true);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_role' => ['required', 'string'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
             
            $user->addRole($request->user_role);


            if ($request->hasFile('main_image')) {

                $mainPath = $request->file('main_image')->store('public/main_images');
                $user->primaryImage()->create([
                    "path" =>  str_replace('public/', 'storage/', $mainPath),
                    'is_main' => true
                ]);
            }



            return response()->json(['status' => true, 'message' => "User created Successfuly"], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json(['status' => true, 'data' => $user]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);


            if ($request->hasFile('main_image')) {
                Storage::delete(public_path($user->primaryImage()->first()->path));
                Storage::delete(storage_path($user->primaryImage()->first()->path));

                $user->primaryImage()->delete();
                $mainPath = $request->file('main_image')->store('public/main_images');
                $user->primaryImage()->create([
                    "path" =>  str_replace('public/', 'storage/', $mainPath),
                    'is_main' => true
                ]);
            }



            return response()->json(['status' => true, 'message' => "User updated Successfuly"], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }

   public function delete($id)
{
    try {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => "User not found"]);
        }

        $image = $user->primaryImage()->first();
        if ($image) {
            Storage::delete($image->path); 
            $image->delete();
        }

        $user->delete();

        return response()->json(['status' => true, 'message' => "User Deleted Successfully"]);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
    }
}
}
