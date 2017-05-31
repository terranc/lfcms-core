<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UikitController extends Controller
{

    public function table()
    {
        flash('阿斯顿')->important();
        flash('阿斯顿')->success()->important();
        flash('阿斯顿')->error()->important();
        flash('阿斯顿')->warning()->important();
        $users = Users::paginate();
        return view('admin.uikit.table', compact('users'));
    }

    public function form()
    {
        return view('admin.uikit.form');
    }

    public function delete($id=0)
    {
        return \Response::json([
            'code' => 1,
            'message' => '删除成功！',
            'data' => null,
        ]);
    }
}
