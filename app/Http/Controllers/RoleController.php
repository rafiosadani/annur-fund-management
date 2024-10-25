<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::with(['permissions', 'dibuat']);

        if ($request->has('view_deleted')) {
            $roles = $roles->onlyTrashed();
        } else {
            $roles = $roles->where('deleted_at', null);
        }
        $roles = $roles->orderBy('created_at', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        $permissions = $this->customPermissions();

        $dashboards = $permissions["dashboard"];
        $users = $permissions["user"];
        $masters = $permissions["master"];

        return view('dashboard.roles.index', [
            'roles' => $roles,
            'dashboards' => $dashboards,
            'users' => $users,
            'masters' => $masters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:m_roles|max:255'
        ];

        $customMessages = [
            'name.required' => 'Nama role harus diisi!',
            'name.unique' => 'Nama role sudah digunakan.',
            'name.max' => 'Nama role terlalu panjang, maksimal 255 karakter!'
        ];

        // Validation input
        try {
            $validatedData = $request->validate($rules, $customMessages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        if (empty($request->input('permissions'))) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withInput()->with('error', 'Pilih permission terlebih dahulu!');
        }

        $createRole = Role::create($validatedData);

        if ($request->filled('permissions')) {
            $createRole->syncPermissions($request->input('permissions'));
        }

        if ($createRole && $request->permissions) {
            return redirect()->route('roles.index')->with('success', 'Data role berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $rules = [];

        if ($request->name != $role->name) {
            $rules['name'] = 'required|max:255|unique:m_roles';
        }

        $customMessage = [
            'name.required' => 'Nama role harus diisi!',
            'name.unique' => 'Nama role sudah digunakan.',
            'name.max' => 'Nama role terlalu panjang, maksimal 255 karakter!'
        ];

        // Validation input
        try {
            $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_role_id' => $role->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        if (empty($request->input('permissions'))) {
            session(['edit_role_id' => $role->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withInput()->with('error', 'Pilih permission terlebih dahulu!');
        } else {
            $updateRole = Role::find($role->id);
            $updateRole->name = $request->input('name');
            $updateRole->save();
        }

        if ($request->filled('permissions')) {
            $updateRole->syncPermissions($request->input('permissions'));
        }

        if ($updateRole && $request->input('permissions')) {
            return redirect()->route('roles.index')->with('success', 'Data role berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $deleteRole = Role::destroy($role->id);

        if ($deleteRole) {
            return redirect()->route('roles.index')->with('success', 'Data role berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restore(string $id) {
        $data = Role::withTrashed()->find($id);

        if ($data) {
            $restore = $data->restore();
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        if ($restore) {
            return redirect()->back()->with('success', 'Data role berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restoreAll() {
        $restoreAll = Role::onlyTrashed()->restore();

        if ($restoreAll) {
            return redirect()->back()->with('success', 'Data role berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    private function customPermissions()
    {
        $permissions = Permission::where('deleted_at', null)->orderBy('created_at', 'asc')->get();
        $customPermission = [];

        foreach ($permissions as $permission) {
            // memisahkan kata berdasarkan tanda '_'
            $fitur = explode('_', $permission->name);
            $fiturGroups = $fitur[0];
            $fiturItems = $fitur[1];

            // memisahkan fitur item dengan tanda '.'
            $key = substr($fiturItems, 0, strpos($fiturItems, '.'));

            // cek apakah sama fiturItems dengan key
            if (str_starts_with($fiturItems, $key)) {
                // masuk customPermission
                $customPermission[$fiturGroups][$key][] = $permission;
            }
        }

        return $customPermission;
    }
}
