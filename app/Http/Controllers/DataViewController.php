<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DfInvoice;
use App\Models\ApprovedCoogsData;
use App\Models\PoInvoice;
use App\Models\Remittance;
use App\Models\ReturnData;
use App\Models\CoogsData;
use Maatwebsite\Excel\Facades\Excel;

class DataViewController extends Controller
{
    public function dfInvoice()
    {
        $data = DfInvoice::latest()->paginate(20);
        return view('data.df_invoice', compact('data'));
    }

    public function approvedCoogs()
    {
        $data = ApprovedCoogsData::latest()->paginate(20);
        return view('data.approved_coogs', compact('data'));
    }

    public function poInvoice()
    {
        $data = PoInvoice::latest()->paginate(20);
        return view('data.po_invoice', compact('data'));
    }

    public function remittance()
    {
        $data = Remittance::latest()->paginate(20);
        return view('data.remittance', compact('data'));
    }

    public function returnData()
    {
        $data = ReturnData::latest()->paginate(20);
        return view('data.return_data', compact('data'));
    }

    public function coogs()
    {
        $data = CoogsData::latest()->paginate(20);
        return view('data.coogs', compact('data'));
    }

    public function showCoogsData()
    {
        $data = CoogsData::orderBy('invoice_date', 'desc')->paginate(10);
        return view('data.coogs', compact('data'));
    }

    public function export()
    {
        return Excel::download(new CoogsData(), 'coogs_data.xlsx');
    }
}
