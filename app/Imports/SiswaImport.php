<?php

namespace App\Imports;

use App\Models\User; // Ganti dengan model yang sesuai
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class   SiswaImport
{
    public function import($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Loop through the rows
        foreach ($data as $index => $row) {
            // Skip the header row
            if ($index == 0) {
                continue;
            }

            User::create([
                'nips' => $row[0],
                'name' => $row[1],
                'password' => $row[2],
                'nohp' => $row[3],
                'kelas' => $row[4],
                'angkatan' => $row[5],
                'is_siswa' => $row[6],
            ]);
        }
    }
}
