<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Province\ProvinceCollection;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    private $provinceModel;
    public function __construct()
    {
        $this->provinceModel = new Province();
    }
    public function index(Request $request)
    {
        $datas = $this->provinceModel->query();

        if ($request->name) {
            $datas->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->id) {
            $datas->where('id', $request->id);
        }

        $datas = new ProvinceCollection($datas->paginate($request->per_page ?? 50));

        $temp = [
            'status_code' => 200,
            'message' => 'Province List',
            'data' => $datas,
        ];

        $temp = array_merge($temp, $datas->toArray($request));

        return response()->json($temp);
    }
}
