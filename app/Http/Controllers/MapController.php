<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GeoSpatialIO\Import\GeoJsonImporter;

class MapController extends Controller
{
    public function provinceIndex(Province $province)
    {
        $type = 'province';

        // Ambil data WKT dari database
        $wktData = DB::select("SELECT ST_AsText(region) FROM provinces WHERE id = ?", [$province->id])[0]->st_astext;

        return view('pages.map', compact('province', 'type', 'wktData'));
    }

    public function updateProvince(Request $request)
    {
        $province = Province::find($request->id);

        if (!$province) {
            return response()->json(['error' => 'Province not found'], 404);
        }

        try {
            // Mengurai data JSON dari klien
            $newRegionData = json_decode($request->userDrawnArea);

            // Validasi data masukan
            if ($newRegionData && isset($newRegionData->features[0]->geometry->coordinates)) {
                $coordinates = $newRegionData->features[0]->geometry->coordinates;

                // Buat format WKT
                $wkt = 'POLYGON((';
                foreach ($coordinates[0] as $point) {
                    $wkt .= $point[0] . ' ' . $point[1] . ', ';
                }
                // Hapus koma dan spasi ekstra di akhir
                $wkt = rtrim($wkt, ', ') . '))';

                // Gunakan transaksi database untuk memastikan konsistensi
                DB::beginTransaction();

                // Set data geometri ke dalam kolom "region"
                $province->region = $wkt;

                // Simpan perubahan
                $province->save();

                // Selesaikan transaksi
                DB::commit();

                return response()->json(['message' => 'Data berhasil diupdate']);
            } else {
                return response()->json(['error' => 'Invalid input data'], 400);
            }
        } catch (\Throwable $th) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function importLocationsProvince(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
            'province_id' => 'required|exists:provinces,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $file = $request->file('file');
        $fileExtension = strtolower($file->getClientOriginalExtension());

        $id = $request->province_id;
        $province = Province::where('id', $id)->first();

        if (!$province) {
            return response()->json(['error' => 'Provinsi dengan ID ' . $id . ' tidak ditemukan.'], 404);
        }

        if ($fileExtension === 'kml') {
            // Import data from KML file
            $kmlFile = $file->getPathname();
            $xml = simplexml_load_file($kmlFile);

            try {
                DB::beginTransaction();

                $coordinates = trim((string)$xml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->coordinates);
                $coordinatePairs = explode(' ', $coordinates);
                $formattedCoordinates = [];

                foreach ($coordinatePairs as $pair) {
                    $coordinates = explode(',', $pair);
                    $longitude = $coordinates[0];
                    $latitude = $coordinates[1];
                    $formattedCoordinates[] = "$longitude $latitude";
                }

                $formattedCoordinates = implode(',', $formattedCoordinates);

                $province->update([
                    'region' => DB::raw("ST_GeomFromText('POLYGON(($formattedCoordinates))')"),
                    // Tambahkan atribut lain sesuai kebutuhan
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['error' => $th->getMessage()], 500);
            }
        } elseif ($fileExtension === 'shp') {
            // Tambahkan kode import SHP di sini

            // Gantilah 'path_to_shp_file' dengan path file SHP yang diunggah
            $shpFilePath = $file->getPathname();

            // Buat koneksi ke database GIS, pastikan Anda telah mengonfigurasi koneksi ke database yang sesuai
            $gisConnection = DB::connection('gis');

            try {
                // masih error perlu perbaikan
                // $shpImporter = new SHPImporter($gisConnection);
                // $shpImporter->import($shpFilePath);

                // Tambahkan atribut lain sesuai kebutuhan
                $province->update([
                    'region' => DB::raw("ST_GeomFromSHP('path_to_shapefile.shp')"),
                    // Tambahkan atribut lain sesuai kebutuhan
                ]);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['error' => $th->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Jenis file tidak valid. Hanya file KML, GCP, atau SHP yang diizinkan.'], 400);
        }

        return response()->json(['message' => 'Data berhasil diimpor']);
    }
}
