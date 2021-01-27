<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;

class ImportExcelControler extends Controller
{
    function index(){
        $data_candidate = DB::table('candidates')->orderBy('id', 'DESC')->get();

        return view('import_excel', compact('data_candidate')); //Getting the information from the candidates table
    }

    function import(Request $request){
        $this->validate($request, [
            'select_file' => 'required|mimes:csv'
        ]);

        $path = $request->file('select_file')->getRealPath();
            
        $data_import = Excel::load($path)->get();

        if($data->count() > 0){
            foreach($data_import->toArray() as $new => $value){
                foreach($value as $row){
                    $new_record[] = array(
                        'id_file' => $row[0],
                        'first_name' => $row[1],
                        'last_name'=> $row[2],
                        'email' => $row[3]
                    );
                }
            }
            if(!empty($new_record)){
                DB::table('candidates')->insert($new_record);
            }
        }
        return;
    }
}
