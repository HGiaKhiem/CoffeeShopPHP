<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mon;
use App\Models\LoaiMon;
use Illuminate\Http\Request;

class MonController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $query = Mon::with('loaiMon');

        if ($search) {
            $query->where('TenMon', 'like', "%$search%");
        }

        $mons = $query->orderBy('ID_Mon', 'asc')->paginate(10);

        return view('admin.mon.index', compact('mons', 'search'));
    }

    public function create()
    {
        $loaiMons = LoaiMon::all();
        return view('admin.mon.create', compact('loaiMons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'TenMon'    => 'required|string|max:255',
            'ID_LoaiMon'=> 'required|integer',
            'Gia'       => 'required|numeric|min:0',
            'MoTa'      => 'nullable|string',
            'TrangThai' => 'required|boolean',
        ]);

        Mon::create($validated);

        return redirect()->route('admin.mon.index')
            ->with('success', 'Thêm món thành công');
    }

    public function edit($id)
    {
        $mon = Mon::findOrFail($id);
        $loaiMons = LoaiMon::all();
        return view('admin.mon.edit', compact('mon', 'loaiMons'));
    }

    public function update(Request $request, $id)
    {
        $mon = Mon::findOrFail($id);

        $validated = $request->validate([
            'TenMon'    => 'required|string|max:255',
            'ID_LoaiMon'=> 'required|integer',
            'Gia'       => 'required|numeric|min:0',
            'MoTa'      => 'nullable|string',
            'TrangThai' => 'required|boolean',
        ]);

        $mon->update($validated);

        return redirect()->route('admin.mon.index')
            ->with('success', 'Cập nhật món thành công');
    }

    public function destroy($id)
    {
        $mon = Mon::findOrFail($id);
        $mon->delete();

        return redirect()->route('admin.mon.index')
            ->with('success', 'Xóa món thành công');
    }
}
