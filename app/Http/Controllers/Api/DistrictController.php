<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\District\DistrictCollection;
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

        if ($request->name) {
            $datas->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->regency_id) {
            $datas->where('regency_id', $request->regency_id);
        }

        $datas = new DistrictCollection($datas->paginate(50));

        return response()->json([
            'status_code' => 200,
            'message' => 'District List',
            'data' => $datas
        ]);
    }
}
