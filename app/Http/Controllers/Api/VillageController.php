<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Village\VillageCollection;
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

        if ($request->name) {
            $datas->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->district_id) {
            $datas->where('district_id', $request->district_id);
        }

        $datas = new VillageCollection($datas->paginate(50));

        return response()->json([
            'status_code' => 200,
            'message' => 'Village List',
            'data' => $datas
        ]);
    }
}
