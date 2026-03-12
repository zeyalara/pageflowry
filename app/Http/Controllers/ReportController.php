<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function create()
    {
        return view('admin.report.create');
    }

    public function store(Request $request)
    {
        // Logic for storing report data
        return redirect()->route('report.index')->with('success', 'Report created successfully');
    }

    public function edit($id)
    {
        return view('admin.report.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic for updating report data
        return redirect()->route('report.index')->with('success', 'Report updated successfully');
    }

    public function destroy($id)
    {
        // Logic for deleting report data
        return redirect()->route('report.index')->with('success', 'Report deleted successfully');
    }
}
