<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori as model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    private $viewIndex = 'indexKategori';
    private $viewForm = 'formKategori';
    private $routePrefix = 'kategori';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Kategori'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Kategori' : 'Tambah Kategori',
            ],
        ];
    }
    
    public function kategori(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Kategori',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Kategori',
            'miniTitle1' => 'Tambah Kategori',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addKategori(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Kategori',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Kategori',
            'miniTitle1' => 'Tambah Kategori',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }
    public function storeKategori(Request $request)
    {
        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $hashedCode = Hash::make(mt_rand(1, 999999));

        $kategori = new Model();
        $kategori->nama = $request->nama;
        $kategori->kode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editKategori($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Kategori',
            'breadcrumbs' => $this->breadcrumbs,
            'breadscrumbs' => 'Dashboard',
            'miniTitle1' => 'Data Kategori',
            'miniTitle' => 'Ubah Kategori',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Model::findOrFail($id);    

        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('kategori', 'nama')->ignore($id),
            ],
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteKategori(Request $request, $id)
    {
        $kategori = Model::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('danger', 'Data berhasil hapus.');;
    }
}
