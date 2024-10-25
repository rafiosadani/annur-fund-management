<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleDonatur = Role::firstWhere('name', 'Donatur');

        if (!empty($roleDonatur)) {
            $m_role_id = $roleDonatur->id;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        $donors = User::with(['dibuat'])
            ->where('deleted_at', null)
            ->where('m_role_id', $m_role_id)
            ->orderBy('created_at', 'desc')
            ->orderBy('user_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        return view('dashboard.donors.index', [
            'donors' => $donors,
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
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:m_users',
            'gender' => 'required',
            'phone' => 'required|min:12',
            'address' => 'required',
            'password' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $customMessage = [
            'name.required' => 'Nama lengkap harus diisi!',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email yang anda masukkan tidak valid / salah.',
            'email.unique' => 'Email yang anda masukkan sudah digunakan.',
            'gender.required' => 'Jenis kelamin harus diisi!',
            'phone.required' => 'No telepon harus diisi!',
            'phone.min' => 'No telepon yang anda masukkan tidak valid / salah.',
            'address.required' => 'Alamat harus diisi!',
            'image.image' => 'Foto yang anda masukkan tidak valid / salah.',
            'image.mimes' => 'Foto yang anda masukkan tidak valid / salah.',
            'image.max' => 'Ukuran file foto yang anda masukkan terlalu besar!',
        ];

        // Validasi input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['create_error' => 'create_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        $roleDonatur = Role::firstWhere('name', 'Donatur');

        if (!empty($roleDonatur)) {
            $m_role_id = $roleDonatur->id;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        // Ambil file gambar dari request
        $image = $request->file('image');

        // Simpan gambar ke folder yang benar
        $imagePath = $image ? $image->store('user-images', 'public') : 'default.png';

        // Simpan data baru ke database menggunakan metode create
        $create = User::create(array_merge($validatedData, ['m_role_id' => $m_role_id, 'user_code' => UserController::generateKode(), 'image' => $imagePath]));

        if ($create) {
            // add role
            $role = Role::findById($create->m_role_id);
            User::find($create->id)->assignRole($role->name);

            return redirect()->route('donors.index')->with('success', 'Data donatur berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $donor)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required',
            'phone' => 'required|min:12',
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($request->email != $donor->email) {
            $rules['email'] = 'required|email:dns|unique:m_users';
        }

        $customMessage = [
            'name.required' => 'Nama lengkap harus diisi!',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email yang anda masukkan tidak valid / salah.',
            'email.unique' => 'Email yang anda masukkan sudah digunakan.',
            'gender.required' => 'Jenis kelamin harus diisi!',
            'phone.required' => 'No telepon harus diisi!',
            'phone.min' => 'No telepon yang anda masukkan tidak valid / salah.',
            'address.required' => 'Alamat harus diisi!',
            'image.image' => 'Foto yang anda masukkan tidak valid / salah.',
            'image.mimes' => 'Foto yang anda masukkan tidak valid / salah.',
            'image.max' => 'Ukuran file foto yang anda masukkan terlalu besar!',
        ];


        // Validation input
        try {
            $validatedData = $request->validate($rules, $customMessage);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session(['edit_donor_id' => $donor->id, 'edit_error' => 'edit_error']);
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        if ($request->file('image')) {
            if ($request->oldImage !== null) {
                if ($request->oldImage !== 'default.png') {
                    Storage::delete($request->oldImage);
                }
            }

            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        if ($request->password !== null) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $roleDonatur = Role::firstWhere('name', 'Donatur');

        if (!empty($roleDonatur)) {
            $m_role_id = $roleDonatur->id;
            $validatedData['m_role_id'] = $m_role_id;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        $update = User::where('id', $donor->id)->update($validatedData);

        if ($update) {
            $role = Role::where('id', $m_role_id)->pluck('name')->first();
            $donor->syncRoles($role);

            return redirect()->route('donors.index')->with('success', 'Data donatur berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $donor)
    {
        $delete = User::destroy($donor->id);

        if ($delete) {
            return redirect()->route('donors.index')->with('success', 'Data donatur berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }
}