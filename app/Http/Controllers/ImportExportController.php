<?php

namespace App\Http\Controllers;

use App\Exports\TransactionHisoryExport;
use App\Imports\UserImport;
use App\Imports\ManagerImport;
use App\Imports\FacilityImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function employeeImport(Request $request)
    {

        $validator = $this->fileValidation($request);

        if ($validator->fails()) {
            $errors = $validator->errors();
            request()->session()->flash('alert-class', 'alert-danger');
            request()->session()->flash('message', $errors->first('file'));

            return back()->withErrors($errors);
        }

        Excel::import(new UserImport, request()->file('file'));
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', 'Employee record imported successfully.');
        return redirect()->route('admin.customers');
    }

    public function managerImport(Request $request)
    {

        $validator = $this->fileValidation($request);

        if ($validator->fails()) {
            $errors = $validator->errors();
            request()->session()->flash('alert-class', 'alert-danger');
            request()->session()->flash('message', $errors->first('file'));

            return back()->withErrors($errors);
        }
        Excel::import(new ManagerImport,request()->file('file'));
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', 'Project manager record imported successfully.');
        return redirect()->route('admin.managers');
    }
    public function facilityImport(Request $request)
    {
        $validator = $this->fileValidation($request);

        if ($validator->fails()) {
            $errors = $validator->errors();
            request()->session()->flash('alert-class', 'alert-danger');
            request()->session()->flash('message', $errors->first('file'));

            return back()->withErrors($errors);
        }

        Excel::import(new FacilityImport, request()->file('file'));
        request()->session()->flash('alert-class', 'alert-success');
        request()->session()->flash('message', 'Facility imported successfully.');
        return redirect()->route('admin.facilities');

    }

    public function fileValidation($request) {

        $rules['file'] = 'required|mimes:xlsx,xls';

        $messages['file.required'] = 'Please select file to upload';
        $messages['file.mimes'] = 'Only xlsx or xls file type allow';

        return \Validator::make($request->all(), $rules);
    }

    public function transactionReportExport(Request $request){
        return Excel::download(new TransactionHisoryExport($request), 'transaction-history-'.date('m-d-Y').'.xlsx');
    }
}
