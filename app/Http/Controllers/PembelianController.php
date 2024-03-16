<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian as model;
use App\Models\Suplay;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PembelianController extends Controller
{
    private $viewIndex = 'indexPembelian';
    private $viewForm = 'formPembelian';
    private $routePrefix = 'pembelian';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Pembelian'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Pembelian' : 'Tambah Pembelian',
            ],
        ];
    }
    
    public function pembelian(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Pembelian',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Pembelian',
            'miniTitle1' => 'Tambah Pembelian',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addPembelian(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Pembelian',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Pembelian',
            'miniTitle1' => 'Tambah Pembelian',
            'listSuplay' => Suplay::get()->pluck('nama', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }

    public function storePembelian(Request $request)
    {
        $customMessages = [
            'id_suplay.required' => 'Suplayer wajib dipilih.',
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'jenis.required' => 'Jenis motor wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'hargaBeli.required' => 'Harga beli wajib diisi.',
            'hargaJual.required' => 'Harga beli wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'id_suplay' => 'required',
            'nama' => [
                'required',
                Rule::unique('pembelian', 'nama'),
            ],
            'jenis' => 'required',
            'stok' => 'required',
            'hargaBeli' => 'required',
            'hargaJual' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $pembelian = new Model();
        $pembelian->id_suplay = $request->id_suplay;
        $pembelian->nama = $request->nama;
        $pembelian->jenis = $request->jenis;
        $pembelian->stok = $request->stok;
        $pembelian->hargaBeli = $request->hargaBeli;
        $pembelian->hargaJual = $request->hargaJual;
        $pembelian->save();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editPembelian($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'listSuplay' => Suplay::get()->pluck('nama', 'id'),
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Pembelian',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Pembelian',
            'miniTitle' => 'Ubah Pembelian',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function updatePembelian(Request $request, $id)
    {
        $pembelian = Model::findOrFail($id);    

        $customMessages = [
            'id_suplay.required' => 'Suplayer wajib dipilih.',
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'jenis.required' => 'Jenis motor wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'hargaBeli.required' => 'Harga beli wajib diisi.',
            'hargaJual.required' => 'Harga beli wajib diisi.',
        ];


        $validator = Validator::make($request->all(), [
            'id_suplay' => 'required',
            'nama' => [
                'required',
                Rule::unique('pembelian', 'nama')->ignore($id),
            ],
            'jenis' => 'required',
            'stok' => 'required',
            'hargaBeli' => 'required',
            'hargaJual' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $pembelian->update([
            'id_suplay' => $request->id_suplay,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'stok' => $request->stok,
            'hargaBeli' => $request->hargaBeli,
            'hargaJual' => $request->hargaJual,
        ]);

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deletePembelian(Request $request, $id)
    {
        $pembelian = Model::findOrFail($id);
        $pembelian->delete();
        return redirect()->route($this->routePrefix . '.index')->with('danger', 'Data berhasil hapus.');;
    }
}
