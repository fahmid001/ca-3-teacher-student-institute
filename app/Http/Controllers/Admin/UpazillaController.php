<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Upazilla;

class UpazillaController extends Controller
{
    public function index(Request $request)
    {
        $upazillaList = Upazilla::get();
        return view('admin.userAccounts.index', compact('userAccounts'));
    }

    public function store(Request $request)
    {
        $nameExist = Upazilla::where('name', $request->name)->first();
        if ($nameExist) {
            return response(['status' => false, 'message' => 'Already exist.'], 422);
        }
        $upazilla = new Upazilla;
        $upazilla->name = $request->name;

        if (!$upazilla->save()) {
            return response(['status' => false, 'message' => 'Failed to store data.'], 422);
        }
        $response = [
            'status' => true,
            'data' => [
                'id' => $upazilla->id,
                'name' => $upazilla->name,
            ],
        ];
        return response($response, 200);
    }
}
