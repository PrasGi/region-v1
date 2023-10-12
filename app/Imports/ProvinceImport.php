<?php

namespace App\Imports;

use App\Models\Province;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ProvinceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Province([
            'name' => $row['name'],
        ]);
    }

    public function onError(\Throwable $e)
    {
        // Rollback the transaction and don't save anything to the database if an error occurs.
        DB::rollBack();
    }

    public function startRow(): int
    {
        // Start the transaction before processing any rows.
        DB::beginTransaction();
        return 2; // This assumes that the header is in the first row.
    }

    public function batchSize(): int
    {
        // Define the batch size for efficient processing.
        return 100;
    }
}
