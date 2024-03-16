<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang as model;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Suplay;
use App\Models\Merek;
use App\Models\Satuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    private $viewIndex = 'indexBarang';
    private $viewForm = 'formBarang';
    private $routePrefix = 'barang';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'dashboard', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Barang'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.edit' ? 'Ubah Barang' : 'Tambah Barang',
            ],
        ];
    }

    public function barang(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where(function($query) use ($searchTerm) {
                $query->where('kode', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('nama', 'LIKE', '%' . $searchTerm . '%');
            })->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Barang',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Barang',
            'miniTitle1' => 'Tambah Barang',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }

    public function addBarang(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Barang',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Barang',
            'miniTitle1' => 'Tambah Barang',
            'listPembelian' => Pembelian::get()->pluck('nama', 'id'),
            'listKategori' => Kategori::get()->pluck('nama', 'id'),
            'listMerek' => Merek::get()->pluck('nama', 'id'),
            'listSatuan' => Satuan::get()->pluck('nama', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }

    public function storeBarang(Request $request)
    {
        $customMessages = [
            'id_pembelian.required' => 'Barang wajib dipilih.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_merek.required' => 'Merek wajib dipilih.',
            'id_satuan.required' => 'Satuan wajib dipilih.',
            'kode.unique' => 'Kode wajib diisi.',
            'kode.required' => 'Kode wajib diisi.',
            'image.required' => 'Gambar wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar maksimal 5 MB.',
        ];

        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'id_merek' => 'required',
            'id_satuan' => 'required',
            'kode' => [
                'required',
                Rule::unique('barang', 'kode'),
            ],
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $barang = new Model();
        $barang->id_kategori = $request->id_kategori;
        $barang->id_merek = $request->id_merek;
        $barang->kode = $request->kode;
        if ($request->hasFile('image')) {
            $barang->image = $request->file('image')->store('public');
        }
        $barang->id_pembelian = $request->id_pembelian;
        $barang->id_satuan = $request->id_satuan;
        $barang->created_at = now();
        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editBarang($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Barang',
            'miniTitle' => 'Ubah Barang',
            'listSuplay' => Suplay::get()->pluck('nama', 'id'),
            'listPembelian' => Pembelian::get()->pluck('nama', 'id'),
            'listKategori' => Kategori::get()->pluck('nama', 'id'),
            'listMerek' => Merek::get()->pluck('nama', 'id'),
            'listSatuan' => Satuan::get()->pluck('nama', 'id'),
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Barang',
            'routePrefix' => $this->routePrefix,
        ];
        return view('dashboard.admin.' . $this->viewForm, $data);
    }

    public function updateBarang(Request $request, $id)
    {
        $barang = Model::findOrFail($id);    

        $customMessages = [
            'id_pembelian.required' => 'Barang wajib dipilih.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_merek.required' => 'Merek wajib dipilih.',
            'id_satuan.required' => 'Satuan wajib dipilih.',
            'kode.unique' => 'Kode wajib diisi.',
            'kode.required' => 'Kode wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar maksimal 5 MB.',
        ];


        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'id_merek' => 'required',
            'id_satuan' => 'required',
            'kode' => [
                'required',
                Rule::unique('barang', 'kode')->ignore($id),
            ],
            'image' => 'image|mimes:jpeg,png,jpg|max:5000',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $barang->update([
            'id_kategori' => $request->id_kategori,
            'id_merek' => $request->id_merek,
            'kode' => $request->kode,
            'id_pembelian' => $request->id_pembelian,
            'id_satuan' => $request->id_satuan,
            'updated_at' => now()
        ]);
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($barang->image) {
                Storage::delete($barang->image);
            }
            // Upload gambar baru
            $barangData['image'] = $request->file('image')->store('public');
            $barang->update($barangData);
        }
        

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteBarang(Request $request, $id)
    {
        $pembelian = Model::findOrFail($id);
        $imagePath = $pembelian->image;

        if ($imagePath) {
            Storage::delete($imagePath);
        }
        $pembelian->delete();
        return redirect()->route($this->routePrefix . '.index')->with('danger', 'Data berhasil hapus.');;
    }
}
