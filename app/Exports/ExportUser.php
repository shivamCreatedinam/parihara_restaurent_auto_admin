<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExportUser implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('user_id','name','mobile','email','gender','created_date')->whereIn('user_type',['USER','SUBADMIN'])->get();
    }
    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Mobile',
            'Email',
            'Gender',
            'Created Date',
        ];
    }
}
