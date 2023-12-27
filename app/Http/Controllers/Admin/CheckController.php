<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ChecksExport;
use App\Http\Controllers\Controller;
use App\Models\Check;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CheckController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.checks.index')->only('index');
        $this->middleware('can:admin.checks.show')->only('show');
    }

    public function index()
    {
        return view('admin.checks.index');
    }

    public function show(Check $check)
    {
        return view('admin.checks.show', compact('check'));
    }

    public function checksToday(){
        return Excel::download(new ChecksExport(), 'checadas_del_dia.xlsx');
    }
}
