<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoaiMon;
use Illuminate\Http\Request;

class LoaiMonController extends Controller
{
    public function index()
    {

        $loais = LoaiMon::orderBy('ID_LoaiMon', 'asc')->paginate(10);

        return view('admin.loaimon.index', compact('loais'));
    }

    public function create()
    {
        return view('admin.loaimon.create');
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'TenLoaiMon' => 'required|string|max:255',
        ]);

        LoaiMon::create($data);

        return redirect()->route('admin.loaimon.index')
            ->with('success', 'Thêm loại món thành công');
    }

    public function edit($id)
    {
        $loai = LoaiMon::findOrFail($id);

        return view('admin.loaimon.edit', compact('loai'));
    }

    public function update(Request $req, $id)
    {
        $loai = LoaiMon::findOrFail($id);

        $data = $req->validate([
            'TenLoaiMon' => 'required|string|max:255',
        ]);

        $loai->update($data);

        return redirect()->route('admin.loaimon.index')
            ->with('success', 'Cập nhật loại món thành công');
    }

    public function destroy($id)
    {
        $loai = LoaiMon::findOrFail($id);

        // Nếu cần, có thể check xem còn món nào thuộc loại này không rồi mới cho xoá
        $loai->delete();

        return redirect()->route('admin.loaimon.index')
            ->with('success', 'Xoá loại món thành công');
    }
}
