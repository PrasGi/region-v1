<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RegencyController extends Controller
{
    private $regencyModel;
    public function __construct()
    {
        $this->regencyModel = new Regency();
    }
    public function index(Request $request)
    {
        $datas = $this->regencyModel->query();

        if ($request->name != null) {
            $datas = $datas->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->province_id != null) {
            $datas = $datas->where('province_id', $request->province_id);
        }

        $datas = $datas->paginate(50);

        return view('pages.regency', compact('datas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'province_id' => 'required|exists:provinces,id',
            // 'id' => 'required|unique:regencies',
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required',
            'regional_center' => 'required'
        ]);

        if ($this->regencyModel->create($validate)) {
            return redirect()->route('regency.index')->with('success', 'Data berhasil ditambahkan');
        }

        return redirect()->route('regency.index')->withErrors(['failed' => 'Data gagal ditambahkan']);
    }

    public function updateForm($id)
    {
        $regency = $this->regencyModel->find($id);
        return view('pages.regency-update', compact('regency'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'province_id' => 'required|exists:provinces,id',
            // 'id' => 'required|unique:regencies,id,' . $id,
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required',
            'regional_center' => 'required'
        ]);

        if ($this->regencyModel->find($id)->update($validate)) {
            return redirect()->route('regency.index')->with('success', 'Data berhasil diubah');
        }

        return redirect()->route('regency.index')->withErrors(['failed' => 'Data gagal diubah']);
    }

    public function destroy($id)
    {
        if ($this->regencyModel->find($id)->delete()) {
            return redirect()->route('regency.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('regency.index')->withErrors(['failed' => 'Data gagal dihapus']);
    }
}
