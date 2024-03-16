<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan as model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SatuanController extends Controller
{
    private $viewIndex = 'indexSatuan';
    private $viewForm = 'formSatuan';
    private $routePrefix = 'satuan';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Satuan'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Satuan' : 'Tambah Satuan',
            ],
        ];
    }
    
    public function satuan(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Satuan',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Satuan',
            'miniTitle1' => 'Tambah Satuan',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addSatuan(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Satuan',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Satuan',
            'miniTitle1' => 'Tambah Satuan',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }
    public function storeSatuan(Request $request)
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

        $satuan = new Model();
        $satuan->nama = $request->nama;
        $satuan->slug = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $satuan->save();

        return redirect()->route('satuan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editSatuan($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Satuan',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Satuan',
            'miniTitle' => 'Ubah Satuan',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function updateSatuan(Request $request, $id)
    {
        $satuan = Model::findOrFail($id);    

        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('satuan', 'nama')->ignore($id),
            ],
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $satuan->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('satuan.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteSatuan(Request $request, $id)
    {
        $satuan = Model::findOrFail($id);
        $satuan->delete();
        return redirect()->route('satuan.index')->with('danger', 'Data berhasil hapus.');;
    }
}
