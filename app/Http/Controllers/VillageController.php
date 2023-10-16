<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    private $villageModel;
    public function __construct()
    {
        $this->villageModel = new Village();
    }
    public function index(Request $request)
    {
        $datas = $this->villageModel->query();

        if ($request->search != null) {
            $datas = $datas->search($request->search);
        }

        if ($request->district_id != null) {
            $datas = $datas->where('district_id', $request->district_id);
        }

        $datas = $datas->paginate(50);

        return view('pages.village', compact('datas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'district_id' => 'required|exists:districts,id',
            // 'id' => 'required|unique:villages,id',
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required',
        ]);

        if ($this->villageModel->create($validate)) {
            return redirect()->route('village.index')->with('success', 'Data berhasil ditambahkan');
        }

        return redirect()->route('village.index')->withErrors(['failed' => 'Data gagal ditambahkan']);
    }

    public function updateForm($id)
    {
        $village = $this->villageModel->find($id);
        return view('pages.village-update', compact('village'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'district_id' => 'required|exists:districts,id',
            // 'id' => 'required|unique:villages,id,' . $id,
            'name' => 'required',
            'large_area' => 'required',
            'total_population' => 'required'
        ]);

        if ($this->villageModel->find($id)->update($validate)) {
            return redirect()->route('village.index')->with('success', 'Data berhasil diubah');
        }

        return redirect()->route('village.index')->withErrors(['failed' => 'Data gagal diubah']);
    }

    public function destroy($id)
    {
        if ($this->villageModel->find($id)->delete()) {
            return redirect()->route('village.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('village.index')->withErrors(['failed' => 'Data gagal dihapus']);
    }
}
