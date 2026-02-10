<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\StudentTemplateExport;
use App\Exports\TransactionTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class TemplateController extends Controller
{
    public function downloadStudentTemplate()
    {
        return Excel::download(new StudentTemplateExport, 'template_import_siswa.xlsx');
    }

    public function downloadTransactionTemplate(\Illuminate\Http\Request $request)
    {
        return Excel::download(new TransactionTemplateExport($request->query('class_id')), 'template_import_transaksi.xlsx');
    }
}
