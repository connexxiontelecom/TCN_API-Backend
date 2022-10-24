<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function __construct()
    {
        $this->employee = new Employee();
        $this->user = new User();
    }

    public function createEmployee(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'fullname' => 'required',
            'staff_id' => 'required',
            'department' => 'required',
            'grade_level' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'type' => 'required'
        ]);

        $parameters = $request->all();
        $parameters["status"] = "Active";

        if($this->employee->isExist($parameters['staff_id']))
        {
            return response()->json("Employee with Staff ID or Email Exist Already ", 400);
        }
        else{

            $result  = $this->employee->createEmployee($parameters);
            if($result)
            {
                return response()->json("Employee created successfully", 200);
            }
            else{
                return response()->json("Something went wrong", 500);
            }
        }



    }

    public function updateEmployee(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'email' => 'required',
            'fullname' => 'required',
            'staff_id' => 'required',
            'job_trade' => 'required',
            //'grade_level' => 'required',
            'designation' => 'required',
            //'phone' => 'required',
            'location' => 'required',
            'type' => 'required'
        ]);

        $parameters = $request->all();
        $result  = $this->employee->updateEmployee($parameters);
        if($result)
        {
            return response()->json("Employee updated successfully", 200);
        }
        else{
            return response()->json("Something went wrong", 500);
        }


    }

    public function uploadDocument(Request $request)
    {
        //$extension = $request->file('carpicture');
        $extension = $request->file('document')->getClientOriginalExtension();
        //$size = $request->file('file')->getSize();
        $dir = 'assets/documents/employees/';
        $documentFilename = uniqid() . '.' . $extension;
        $request->file('document')->move($this->public_path($dir), $documentFilename);
        $response = $this->parseDocuments($documentFilename);
        if ($response) {
            return response()->json("Successfully parsed data", 200);
        } else {
            return response()->json("Something went wrong while processing", 500);
        }
    }

    public function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }

    public function parseDocuments($filename)
    {
        $path = 'assets/documents/employees/' . $filename;
        $result = $this->parseFileForEmployees($path);
        unlink($path);
        //File::delete($path);
        return $result;
    }

    public function parseFileForEmployees($path)
    {
        $data = "";
        $reader = ReaderEntityFactory::createReaderFromFile($path);
        $reader->open($path);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // do stuff with the row
                $cells = $row->getCells();
                /*foreach ($cells as $cell){
                    $cell_value = $cell->getValue();
                    echo "Cell Value = $cell_value<br>\n";
                }*/
                $parameters = array();
                for ($i = 0; $i < count($cells); $i++) {
                    $keys = array('SN', 'staff_id', 'fullname', 'designation', 'status', 'type', 'job_trade', 'location');
                    $data = $cells[$i]->getValue();
                    $parameters[$keys[$i]] = $data;
                }
                $this->employee->createEmployee($parameters);
            }
        }
        $reader->close();
        return true;
    }

    public function parseFileForUsers($path)
    {
        $data = "";
        $reader = ReaderEntityFactory::createReaderFromFile($path);
        $reader->open($path);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // do stuff with the row
                $cells = $row->getCells();
                /*foreach ($cells as $cell){
                    $cell_value = $cell->getValue();
                    echo "Cell Value = $cell_value<br>\n";
                }*/
                $parameters = array();
                for ($i = 0; $i < count($cells); $i++) {
                    $keys = array('SN', 'staff_id', 'fullname', 'designation', 'status', 'type', 'job_trade', 'location');
                    $data = $cells[$i]->getValue();
                    $parameters[$keys[$i]] = $data;
                    $parameters["email"] = uniqid() . "@tcn.com";
                }
                $this->user->createUser($parameters);
            }
        }
        $reader->close();
        return true;
    }

    public function allEmployees()
    {
        $responsse = $this->employee->allEmployees();
        return response()->json($responsse, 200);
    }

}
