<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Regency\RegencyCollection;
use App\Models\Regency;
use Illuminate\Http\Request;

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

        if ($request->name) {
            $datas->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->province_id) {
            $datas->where('province_id', $request->province_id);
        }

        $datas = new RegencyCollection($datas->paginate($request->per_page ?? 50));

        $temp = [
            'status_code' => 200,
            'message' => 'Province List',
            'data' => $datas,
        ];

        $temp = array_merge($temp, $datas->toArray($request));

        return response()->json($temp);
    }
}
