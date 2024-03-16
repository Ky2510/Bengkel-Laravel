<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merek as model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MerekController extends Controller
{
    private $viewIndex = 'indexMerek';
    private $viewForm = 'formMerek';
    private $routePrefix = 'merek';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Merek'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Merek' : 'Tambah Merek',
            ],
        ];
    }
    
    public function merek(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Merek',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Merek',
            'miniTitle1' => 'Tambah Merek',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addMerek(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Merek',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Merek',
            'miniTitle1' => 'Tambah Merek',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }
    
    public function storeMerek(Request $request)
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

        $merek = new Model();
        $merek->nama = $request->nama;
        $merek->kode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $merek->save();

        return redirect()->route('merek.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editMerek($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Merek',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Merek',
            'miniTitle' => 'Ubah Merek',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function updateMerek(Request $request, $id)
    {
        $merek = Model::findOrFail($id);    

        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('merek', 'nama')->ignore($id),
            ],
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $merek->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('merek.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteMerek(Request $request, $id)
    {
        $merek = Model::findOrFail($id);
        $merek->delete();
        return redirect()->route('merek.index')->with('danger', 'Data berhasil hapus.');;
    }
}
