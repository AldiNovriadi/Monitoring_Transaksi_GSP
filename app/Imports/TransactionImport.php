<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;

class TransactionImport implements ToModel
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
            'biller_id'     => $row[3],
            'produk_id'    => $row[4],
            'bank_id'      => $row[5],
            'rekening'  => $row[6],
            'bulan'     => $row[7],
            'rptag'     => $row[8],
            'rpadm'     => $row[9],
            'total'     => $row[10],
        ]);
    }
}
