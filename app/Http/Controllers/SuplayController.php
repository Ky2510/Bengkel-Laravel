<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplay as model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SuplayController extends Controller
{
    private $viewIndex = 'indexSuplay';
    private $viewForm = 'formSuplay';
    private $routePrefix = 'suplay';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Suplay'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Suplay' : 'Tambah Suplay',
            ],
        ];
    }
    
    public function suplay(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Suplay',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Suplay',
            'miniTitle1' => 'Tambah Suplay',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addSuplay(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Suplay',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Suplay',
            'miniTitle1' => 'Tambah Suplay',
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
        ]);
    }
    public function storesuplay(Request $request)
    {
        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $suplay = new Model();
        $suplay->nama = $request->nama;
        $suplay->no_hp = $request->no_hp;
        $suplay->alamat = $request->alamat;
        $suplay->save();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editSuplay($id)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UBAH',
            'title' => 'Ubah Suplay',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Suplay',
            'miniTitle' => 'Ubah Suplay',
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function updateSuplay(Request $request, $id)
    {
        $suplay = Model::findOrFail($id);    

        $customMessages = [
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('suplay', 'nama')->ignore($id),
            ],
            'alamat' => [
                'required',
            ],
            'no_hp' => [
                'required',
            ],
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $suplay->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteSuplay(Request $request, $id)
    {
        $suplay = Model::findOrFail($id);
        $suplay->delete();
        return redirect()->route($this->routePrefix . '.index')->with('danger', 'Data berhasil hapus.');;
    }
}
