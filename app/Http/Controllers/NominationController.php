<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Nomination;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class NominationController extends Controller
{
    public function __construct()
    {
        $this->nomination = new Nomination();
        $this->schedule = new TrainingSchedule();
        $this->employee= new Employee();
    }

    public function createNomination(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required',
            'schedule' => 'required',
        ]);
        $parameters = $request->all();
        $result = $this->nomination->createNomination($parameters);
        if ($result) {
            return response()->json("Nominations submitted successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function getNominations(){
       $nominations =  $this->nomination->getNominations();
       foreach ($nominations as $nomination)
       {
           $nomination->training = $this->schedule->getSchedule($nomination->nm_training_id);
           $nomination->NominatedBy;
           $nomination->NominatedEmployee;
           $nomination->year;
       }
        if ($nominations) {
            return response()->json($nominations, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function getNominationsById(Request $request, $id){
        $nominations =  $this->nomination->getNominationsByMe($id);
        if ($nominations) {
            return response()->json($nominations, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }

    public function approveNomination(Request $request, $id)
    {
        $nomination = Nomination::find($id);
        $nomination->nm_status = 2;
        $nomination->save();
        return $this->getNominations();
    }

    public function declineNomination(Request $request, $id){
        $nomination = Nomination::find($id);
        $nomination->nm_status = 3;
        $nomination->save();
        return $this->getNominations();
    }

    public function getNominee(Request $request, $id){
        $nominees = $this->nomination->getNominees($id);

        foreach ($nominees as $nominee)
        {
            $nominee->NominatedEmployee;
            //$nominee->em = $this->employee->getEmployee($nominee->nm_employee_id);
            //$nominee->NominatedBy;
            //$nominee->year;
        }
        if ($nominees) {
            return response()->json($nominees, 200);
        } else {
            return response()->json("Something went wrong", 500);
        }

    }

    public function updateNominee(Request $request){
        $this->validate($request, [
            'nominees' => 'required',
            'schedule' => 'required',
            'SummaryNote'=>'required',
            'FacilitatorRating'=>'required',
            'TrainingRating'=>'required'
        ]);
        $parameters = $request->all();
        $result  =  $this->nomination->updateNominees($parameters);
        if ($result) {
            return response()->json("Evaluation Submitted Successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }




}
