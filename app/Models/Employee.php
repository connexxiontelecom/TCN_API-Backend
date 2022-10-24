<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function createEmployee(array $parameters)
    {
        if(!$this->isExist($parameters['staff_id'])){
            $emp = new Employee();
            $emp->fullname = $parameters['fullname'];
            $emp->email = $this->generateEmail($parameters['fullname'])."@tcn.com";
            $emp->staff_id = $parameters['staff_id'];
            $emp->designation = $parameters['designation'];
            $emp->type = $parameters['type'];
            $emp->job_trade = $parameters['job_trade'];
            $emp->location = $parameters['location'];
            $emp->status = $parameters['status'] == "Active" ? 1 : 0;
            $emp->save();
            $user = new User();
            $user->createUser(["fullname"=>$emp->fullname, "email"=>$emp->email, "staff_id"=>$emp->staff_id]);
            return true;
        }
        else{

            return; //false;
        }
    }



    public function updateEmployee(array $parameters)
    {

            $emp= Employee::find($parameters['id']);
            $emp->fullname = $parameters['fullname'];
            //$emp->email = $this->generateEmail($parameters['fullname'])."@tcn.com";
            $emp->staff_id = $parameters['staff_id'];
            $emp->designation = $parameters['designation'];
            $emp->type = $parameters['type'];
            $emp->job_trade = $parameters['job_trade'];
            $emp->location = $parameters['location'];
            //$emp->status = $parameters['status'] == "Active" ? 1 : 0;
            $emp->save();
           // $user = new User();
           // $user->createUser(["fullname"=>$emp->fullname, "email"=>$emp->email, "staff_id"=>$emp->staff_id]);
            return true;
    }

    public function isExist($staffId){
        //$exists = User::where("email", $email)->orWhere('staff_id', $staffId)->first();
        $exists = Employee::where('staff_id', $staffId)->first();
        if ($exists != null) {
            return true;
        }
        else{
            return false;
        }
    }

    //generates email from names
    private function generateEmail($fullname)
    {
        $email = "";
        $names =  explode(" ", $fullname);
        if (!is_null($names) && count($names) > 0) {
            $email = $names[0] . $this->generateRandomString(5);
            /*if (count($names) > 1) {
                $email = $names[0] . $names[count($names) - 1] . "@tcn.ng.com";
            } else {
                $email = $names[0] . "@tcn.ng.com";
            }*/
        } else {
            $$email = generateRandomString($length = 20) . "@tcn.ng.com";
        }
        return $email;
    }

    private function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function allEmployees(){
        return Employee::all();
    }

    public function getEmployee($id)
    {
        return Employee::find($id);
    }
}
