<?php

namespace App\Http\Controllers;

use App\Models\Datauser as model;
use App\Models\User;    

use Illuminate\Http\Request;

class UserController extends Controller
{
    private $viewIndex = 'indexUser';
    private $routePrefix = 'user';
    private $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [
            ['route' => 'admin', 'label' => 'Dashboard'],
            ['route' => $this->routePrefix . '.index', 'label' => 'Data User'],
            // [
                // 'route' => $this->routePrefix . '.show',
                // 'label' => \Route::currentRouteName() == $this->routePrefix . '.show' ? 'Data User' : '',
            // ],
        ];
    }

    public function index(Request $request)
    {
        $models = Model::all();
        return view('dashboard.admin.' . $this->viewIndex, [
            'title' => 'User',
            'breadcrumbs' => $this->breadcrumbs,
            'miniTitle' => 'Data User',
            'routePrefix' => $this->routePrefix,
            'models' => $models,
        ]);
    }

    public function updateStatusUser(Request $request)
    {
        if ($request->model == 'user') {
            $model = User::findOrFail($request->id);
            $model->setStatus($request->status);
            $model->save();
            
            if ($request->status == 'aktif') {
                return redirect()->back()->with('success', 'User berhasil di aktifkan.');
            }else{
                return redirect()->back()->with('danger', 'User berhasil di non-aktifkan.');
            }
        }
    }
}
