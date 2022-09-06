<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;

class TransactionImport implements ToModel, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Transaction([
            'tanggal'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'cid_id'       => $row[1],
            'kd_id'        => $row[2],
            // 'biller_id'     => $row[3],
            'produk_id'    => $row[3],
            'bank_id'      => $row[4],
            'rekening'  => $row[5],
            'bulan'     => $row[6],
            'rptag'     => $row[7],
            'rpadm'     => $row[8],
            'total'     => $row[9],
            'created_by' => auth()->user()->id
        ]);
    }

    public function rules(): array
    {
        return [
            '*.0' => 'numeric',
            '*.1' => 'numeric',
            '*.2' => 'numeric',
            '*.3' => 'numeric',
            '*.4' => 'numeric',
            '*.5' => 'numeric',
            '*.6' => 'numeric',
            '*.7' => 'numeric',
            '*.8' => 'numeric',
            '*.9' => 'numeric',
        ];
    }
    public function customValidationMessages()
    {
        return [
            '*.0.numeric' => 'Tipe Data Tidak Sesuai',
            '*.1.numeric' => 'Tipe Data Tidak Sesuai',
            '*.2.numeric' => 'Tipe Data Tidak Sesuai',
            '*.3.numeric' => 'Tipe Data Tidak Sesuai',
            '*.4.numeric' => 'Tipe Data Tidak Sesuai',
            '*.5.numeric' => 'Tipe Data Tidak Sesuai',
            '*.6.numeric' => 'Tipe Data Tidak Sesuai',
            '*.7.numeric' => 'Tipe Data Tidak Sesuai',
            '*.8.numeric' => 'Tipe Data Tidak Sesuai',
            '*.9.numeric' => 'Tipe Data Tidak Sesuai',
        ];
    }
}
