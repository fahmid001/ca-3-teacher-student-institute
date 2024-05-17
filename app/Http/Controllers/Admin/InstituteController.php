<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InstituteService;

use App\Models\Institute;

use Exception;

class InstituteController extends Controller
{
    private $instituteService;

    public function __construct(InstituteService $instituteService)
    {
        $this->instituteService = $instituteService;
    }

    public function index(Request $request)
    {
        try {
            $institutes = $this->instituteService->list();
            return view('admin.institutes.index', compact('institutes'));
        } catch (Exception $e) {
            return back()->with($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'eiin' => 'required',
            'institute_name' => 'required',
            'institute_type' => 'required',
        ]);

        try {
            $this->instituteService->create($request->all());
            return redirect()->route('institutes.index');
        } catch (Exception $e) {
            return back()->with($e->getMessage());
        }
    }
}
