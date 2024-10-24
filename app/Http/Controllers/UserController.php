<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with(['dibuat']);
        if ($request->has('view_deleted')) {
            $users = $users->onlyTrashed();
        } else {
            $users = $users->where('deleted_at', null);
        }
        $users = $users->orderBy('created_at', 'desc')
            ->orderBy('user_code', 'desc')
            ->filter(request(['search']))->paginate(5)->withQueryString();

        $roles = Role::whereNull('deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        return view('dashboard.users.index', [
            'users' => $users,
            'roles' => $roles
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
            'm_role_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:m_users',
            'gender' => 'required',
            'phone' => 'required|min:12',
            'address' => 'required',
            'password' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $customMessage = [
            'm_role_id.required' => 'Role tidak boleh kosong, pilih role terlebih dahulu!.',
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

        // Ambil file gambar dari request
        $image = $request->file('image');

        // Simpan gambar ke folder yang benar
        $imagePath = $image ? $image->store('user-images', 'public') : 'default.png';

        // Simpan data baru ke database menggunakan metode create
        $create = User::create(array_merge($validatedData, ['user_code' => $this->generateKode(), 'image' => $imagePath]));

        if ($create) {
            // add role
            $role = Role::findById($create->m_role_id);
            User::find($create->id)->assignRole($role->name);

            // Hapus gambar sementara jika ada
            if ($request->session()->has('temp_image')) {
                Storage::disk('public')->delete($request->session()->get('temp_image'));
            }

            return redirect()->route('users.index')->with('success', 'Data user berhasil ditambahkan!');
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
    public function update(Request $request, User $user)
    {
        $rules = [
            'm_role_id' => 'required',
            'name' => 'required|max:255',
            'gender' => 'required',
            'phone' => 'required|min:12',
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:m_users';
        }

        $customMessage = [
            'm_role_id.required' => 'Role tidak boleh kosong, pilih role terlebih dahulu!.',
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
            session(['edit_user_id' => $user->id, 'edit_error' => 'edit_error']);
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

        $update = User::where('id', $user->id)->update($validatedData);

        if ($update) {
            $role = Role::where('id', $request->m_role_id)->pluck('name')->first();
            $user->syncRoles($role);

            return redirect()->route('users.index')->with('success', 'Data user berhasil diedit!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $delete = User::destroy($user->id);

        if ($delete) {
            return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restore(string $id) {
        $data = User::withTrashed()->find($id);

        if ($data) {
            $restore = $data->restore();
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }

        if ($restore) {
            return redirect()->back()->with('success', 'Data user berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public function restoreAll() {
        $restoreAll = User::onlyTrashed()->restore();

        if ($restoreAll) {
            return redirect()->back()->with('success', 'Data user berhasil direstore!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada server!');
        }
    }

    public static function generateKode()
    {
        try {
            // Mengambil kode terakhir
            $last_kode = User::select("user_code")
                ->whereMonth("created_at", Carbon::now())
                ->whereYear("created_at", Carbon::now())
                ->where(DB::raw("substr(user_code, 1, 3)"), "=", "USR")
                ->orderBy("user_code", "desc")
                ->withTrashed()
                ->first();

            $prefix = "USR";
            $year = date("y");
            $month = date("m");

            // Generate Kode
            if ($last_kode) {
                $monthKode = explode("/", $last_kode->user_code);
                $monthKode = substr($monthKode[1], 2, 4);
                if ($month == $monthKode) {
                    $last = explode("/", $last_kode->user_code);
                    $last[2] = (int)++$last[2];
                    $urutan = str_pad($last[2], 4, '0', STR_PAD_LEFT);
                    $kode = $prefix . "/" . $year . $month . "/" . $urutan;
                } else {
                    $kode = $prefix . "/" . $year . $month . "/" . "0001";
                }
            } else {
                $kode = $prefix . "/" . $year . $month . "/" . "0001";
            }

            return $kode;
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "error" => "Terjadi kesalahan pada server",
                "dev" => $th->getMessage() . " at line " . $th->getLine() . " in " . $th->getFile()
            ];
        }
    }
}
