<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        return view('admin.approval.index');
    }

    public function create()
    {
        return view('admin.approval.create');
    }

    public function store(Request $request)
    {
        // Logic for storing approval data
        return redirect()->route('approval.index')->with('success', 'Approval created successfully');
    }

    public function edit($id)
    {
        return view('admin.approval.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic for updating approval data
        return redirect()->route('approval.index')->with('success', 'Approval updated successfully');
    }

    public function destroy($id)
    {
        // Logic for deleting approval data
        return redirect()->route('approval.index')->with('success', 'Approval deleted successfully');
    }
}
