<?php

namespace App\Http\Controllers;

use App\Imports\ProvinceImport;
use App\Models\Province;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class ProvinceController extends Controller
{
    private $provinceModel;
    public function __construct()
    {
        $this->provinceModel = new Province();
    }
    public function index(Request $request)
    {
        $datas = isEmpty($request->search) ? $this->provinceModel->search($request->search)->paginate(50) : $this->provinceModel->paginate(50);

        return view('pages.province', compact('datas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            // 'id' => 'required|unique:provinces',
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required',
            'regional_center' => 'required'
        ]);

        if ($this->provinceModel->create($validate)) {
            return redirect()->route('province.index')->with('success', 'Data berhasil ditambahkan');
        }

        return redirect()->route('province.index')->withErrors(['failed' => 'Data gagal ditambahkan']);
    }

    public function updateForm($id)
    {
        $province = $this->provinceModel->find($id);
        return view('pages.province-update', compact('province'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            // 'id' => 'required|unique:provinces,id,' . $id . ',id',
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required',
            'regional_center' => 'required'
        ]);

        if ($this->provinceModel->find($id)->update($validate)) {
            return redirect()->route('province.index')->with('success', 'Data berhasil diubah');
        }

        return redirect()->route('province.index')->withErrors(['failed' => 'Data gagal diubah']);
    }

    public function destroy($id)
    {
        if ($this->provinceModel->find($id)->delete()) {
            return redirect()->route('province.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('province.index')->withErrors(['failed' => 'Data gagal dihapus']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $result = Excel::import(new ProvinceImport, $file);

        if ($result) {
            return redirect()->route('province.index')->with('success', 'Data berhasil diimport');
        }

        return redirect()->route('province.index')->withErrors(['failed' => 'Data gagal diimport']);
    }
}