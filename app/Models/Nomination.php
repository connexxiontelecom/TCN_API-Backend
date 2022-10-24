<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Year;
use App\Models\TrainingSchedule;
class Nomination extends Model
{
    public function NominatedBy(){
        return $this->belongsTo(Employee::class, 'nm_nominated_by');
    }

    public function NominatedEmployee(){
        return $this->belongsTo(Employee::class, 'nm_employee_id');
    }

    public function selectedTraining(){
        return $this->belongsTo(TrainingSchedule::class, 'nm_training_id');
    }

    public function year(){
        return $this->belongsTo(Year::class, 'nm_year');
    }

    public function  createNomination(array $parameters)
    {
        foreach (json_decode($parameters["ids"]) as $param){
            $nm= new Nomination();
            $nm->nm_employee_id = $param;
            $nm->nm_training_id = $parameters['schedule'];
            $nm->nm_nominated_by = 2;
            $nm->nm_status = 1;// 1 Pending  - 2 Approved -3 Declined
            $year  = new Year();
            $yr = $year->createYear(date('Y'));
            $nm->nm_year = $yr->id;//date('Y');//current year
            $nm->save();
        }
        return true;
    }

    public function getNominations(){
        return Nomination::all();
    }

    public function getNominationsByMe($id)
    {
        return Nomination::where("nm_nominated_by", $id)->get();
    }

    public function getNominees($id){
        $evaluated = 5;
        $pending = 2;
        return Nomination::where(function ($query) use ($id, $evaluated) {
            $query->where('nm_training_id', $id)->where("nm_status", $evaluated);
        })->oRwhere(function ($query) use ($id, $pending) {
            $query->where('nm_training_id', $id)->where("nm_status", $pending);
        })->get();
       // return Nomination::where("nm_training_id", $id)->where("nm_status", 2)->oRWhere("nm_status", 4)->get();
    }

    public function updateNominees(array $parameters){

        foreach (json_decode($parameters['nominees']) as $nominee)
        {
            $_nominee = Nomination::find($nominee->id);
            $_nominee->nm_status = 5;//completed || Evaluated
            $_nominee->nm_attendance = $nominee->nm_attendance;
            $_nominee->nm_punctuality = $nominee->nm_punctuality;
            $_nominee->save();
        }

        $schedule = TrainingSchedule::find($parameters['schedule']);
        $schedule->ts_status = 5;//completed
        $schedule->ts_evaluation_note = $parameters['SummaryNote'];
        $schedule->ts_instructor_rating = $parameters['FacilitatorRating'];
        $schedule->ts_training_rating = $parameters['TrainingRating'];
        $schedule->save();
        return true;
    }

}
