<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota as model;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AnggotaController extends Controller
{
    private $viewIndex = 'indexAnggota';
    private $viewForm = 'formAnggota';
    private $routePrefix = 'anggota';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Anggota'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.ubah' ? 'Ubah Anggota' : 'Tambah Anggota',
            ],
        ];
    }

    public function anggota(Request $request)
    {
        $anggota = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $anggota->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $anggota->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Anggota',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Anggota',
            'miniTitle1' => 'Tambah Anggota',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    public function addAnggota(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Anggota',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Anggota',
            'miniTitle1' => 'Tambah Anggota',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }

    public function storeAnggota(Request $request)
    {
        $user = new User();
        $customMessages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password wajib diisi dan harus memiliki setidaknya 8 karakter.',
            'nama.required' => 'Nama wajib diisi.',
            'jeniskelamin.required' => 'Jenis kelamin wajib diisi.',
            'tpt_lhr.required' => 'Tempat lahir wajib diisi.',
            'tgl_lhr.required|date' => 'Tanggal lahir wajib diisi dengan format yang benar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor telepon wajib diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'username' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required|min:8',
            'nama' => 'required',
            'jeniskelamin' => 'required',
            'tpt_lhr' => 'required' ,
            'tgl_lhr' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->akses = 'admin'; 
        $user->save();

        $anggota = new Model();
        $anggota->user_id = $user->id;
        $anggota->nama = $request->nama;
        $anggota->jeniskelamin = $request->jeniskelamin;
        $anggota->tpt_lhr = $request->tpt_lhr;
        $anggota->tgl_lhr = $request->tgl_lhr;
        $anggota->alamat = $request->alamat;
        $anggota->no_hp = $request->no_hp;
        $anggota->save();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editAnggota($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'breadcrumbs' => $this->breadcrumbs,
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Anggota',
            'breadscrumbs' => 'Dashboard',
            'miniTitle1' => 'Data Anggota',
            'miniTitle' => 'Ubah Anggota',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function editAkunAnggota($id)
    {
        $data = [
            'model' => User::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update-akun', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Akun Anggota',
            'breadcrumbs' => $this->breadcrumbs,
            'breadscrumbs' => 'Dashboard',
            'miniTitle1' => 'Data Akun Anggota',
            'miniTitle' => 'Ubah Akun Anggota',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    
    public function updateAkunAnggota(Request $request, $id)
    {
        $anggota = $id;
        $user = User::findOrFail($id);

        $customMessages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'username' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function updateAnggota(Request $request, $id)
    {
        $anggota = Model::findOrFail($id);

        $anggota->update([
            'nama' => $request->nama,
            'jeniskelamin' => $request->jeniskelamin,
            'tpt_lhr' => $request->tpt_lhr,
            'tgl_lhr' => $request->tgl_lhr,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteAnggota(Request $request, $id)
    {
        $anggota = Model::findOrFail($id);
        $user = User::findOrFail($anggota->user->id);
        $anggota->delete();
        $user->delete();
        return redirect()->route($this->routePrefix . '.index')->with('danger', 'Data berhasil hapus.');;
    }
}
