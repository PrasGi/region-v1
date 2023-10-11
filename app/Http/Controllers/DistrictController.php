<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    private $districtModel;
    public function __construct()
    {
        $this->districtModel = new District();
    }
    public function index(Request $request)
    {
        $datas = $this->districtModel->query();

        if ($request->search != null) {
            $datas = $datas->search($request->search);
        }

        if ($request->regency_id != null) {
            $datas = $datas->where('regency_id', $request->regency_id);
        }

        $datas = $datas->paginate(50);

        return view('pages.district', compact('datas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'regency_id' => 'required|exists:regencies,id',
            'id' => 'required|unique:districts,id',
            'name' => 'required'
        ]);

        if ($this->districtModel->create($validate)) {
            return redirect()->route('district.index')->with('success', 'Data berhasil ditambahkan');
        }

        return redirect()->route('district.index')->withErrors(['failed' => 'Data gagal ditambahkan']);
    }

    public function updateForm($id)
    {
        $district = $this->districtModel->find($id);
        return view('pages.district-update', compact('district'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'regency_id' => 'required|exists:regencies,id',
            'id' => 'required|unique:districts,id,' . $id,
            'name' => 'required'
        ]);

        if ($this->districtModel->find($id)->update($validate)) {
            return redirect()->route('district.index')->with('success', 'Data berhasil diubah');
        }

        return redirect()->route('district.index')->withErrors(['failed' => 'Data gagal diubah']);
    }

    public function destroy($id)
    {
        if ($this->districtModel->find($id)->delete()) {
            return redirect()->route('district.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('district.index')->withErrors(['failed' => 'Data gagal dihapus']);
    }
}
