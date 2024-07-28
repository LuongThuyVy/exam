<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Display a listing of roles
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // Store a newly created role in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);

        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    // Display the specified role
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    // Update the specified role in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:20',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        return response()->json($role);
    }

    // Remove the specified role from storage
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
