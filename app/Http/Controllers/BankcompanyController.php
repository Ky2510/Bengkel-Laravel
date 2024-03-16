<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bankcompany as model;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BankcompanyController extends Controller
{
    private $viewIndex = 'indexBank';
    private $viewForm = 'formBank';
    private $routePrefix = 'bank';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data Bank'],
            [
                'route' => $this->routePrefix . '.create',
                'label' => \Route::currentRouteName() == $this->routePrefix . '.ubah' ? 'Ubah Bank' : 'Tambah Bank',
            ],
        ];
    }
    
    public function bankIndex(Request $request)
    {
        $models = Model::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $models = $models->where('nama_bank', 'LIKE', '%' . $searchTerm . '%')->paginate(5);
        } else {
            $models = $models->paginate(5);
        }
        
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'Bank',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Bank',
            'miniTitle1' => 'Tambah Bank',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }
    
    public function addBank(Request $request)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'title' => 'Bank',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data Bank',
            'miniTitle1' => 'Tambah Bank',
            'listBank' => Bank::get()->pluck('nama_bank', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'routePrefix' => $this->routePrefix,
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
        ]);
    }

    public function storeBank(Request $request)
    {
        $customMessages = [
            'bank_id.required' => 'Nama bank wajib dipilih.',
            'nama_rekening.required' => 'Nama rek. wajib diisi.',
            'nomor_rekening.required' => 'Nomor rek. wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bankCompany = new Model();
        $bank = Bank::find($request['bank_id']);
        unset($bankCompany['bank_id']);
        $bankCompany['kode'] = $bank->sandi_bank;
        $bankCompany['nama_bank'] = $bank->nama_bank;
        $bankCompany->nama_rekening = $request->nama_rekening;
        $bankCompany->nomor_rekening = $request->nomor_rekening;
        $bankCompany->created_at = now();
        $bankCompany->save();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data berhasil disimpan.');
    }

    public function editBank($id)
    {
        return view('dashboard.admin.' . $this->viewForm, [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Ubah',
            'title' => 'Ubah Bank',
            'listBank' => \App\Models\Bank::pluck('nama_bank', 'id'),
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle1' => 'Data Bank',
            'miniTitle' => 'Ubah Bank',
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function updateBank(Request $request, $id)
    {
        $bankCompany = Model::findOrFail($id);    

        $customMessages = [
            'bank_id.required' => 'Nama bank wajib dipilih.',
            'nama_rekening.required' => 'Nama rek. wajib diisi.',
            'nomor_rekening.required' => 'Nomor rek. wajib diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $bank = Bank::find($request['bank_id']);
        unset($bankCompany['bank_id']);
        $bankCompany->update([
            'kode' => $bank->sandi_bank,
            'nama_bank' => $bank->nama_bank,
            'nama_rekening' => $request->nama_rekening,
            'nomor_rekening' => $request->nomor_rekening,
            'updated_at' => now(),
        ]);

        return redirect()->route($this->routePrefix . '.index')->with('warning', 'Data berhasil diubah.');
    }

    public function deleteBank(Request $request, $id)
    {
        $bankCompany = Model::findOrFail($id);
        $bankCompany->delete();
        return redirect()->route($this->routePrefix . '.index')->with('danger', 'Data berhasil hapus.');;
    }
}

