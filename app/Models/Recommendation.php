<?php

namespace App\Models;

use App\Models\Year;
use App\Models\TrainingSchedule;

use Illuminate\Database\Eloquent\Model;


class Recommendation extends Model
{

    public function RecommendedBy(){
        return $this->belongsTo(Employee::class, 'rec_recommended_by');
    }

    public function RecommendedEmployee(){
        return $this->belongsTo(Employee::class, 'rec_employee');
    }

    public function year(){
        return $this->belongsTo(Year::class, 'rec_year');
    }

   public function  createRecommendation(array $parameters)
    {

        foreach ( json_decode($parameters["employees"]) as $param){
            $rec= new Recommendation();
            $rec->rec_employee = $param->value;//$parameters['employee'];
            $rec->rec_name = $parameters['Title'];
            $rec->rec_type = $parameters['TypeofTraining'];
            $rec->rec_description = $parameters['Description'];
            $rec->rec_recommended_by = 2;//$parameters['location'];
            $rec->rec_status = 1;// 1 Not SCHEDULED - 2 SCHEDULED -
            $year  = new Year();
            $yr = $year->createYear(date('Y'));
            $rec->rec_year = $yr->id;//date('Y');//current year
            $rec->save();
        }

        return true;
    }

    public function recommendations($period){

      if($period!=0){
          return Recommendation::where('rec_year', $period)->get();
      }
      else{
          return Recommendation::all();
      }
    }


    public function  addRecommendationToSchedule($parameters){
        //create training Schedule from Recommendation
        $schedule  =  new TrainingSchedule();
        $schedule->createSchedule($parameters);

        //mark recommendation as scheduled
        $rec =  Recommendation::find($parameters['id']);
        $rec->rec_status = 2;//scheduled
        $rec->save();
        return true;

    }

    public function createSchedule(array $parameters){

        $ts= new TrainingSchedule();
        $ts->ts_title = $parameters['Title'];
        $ts->ts_description = $parameters['Description'];
        $ts->ts_type = $parameters['TypeofTraining'];
        $ts->ts_department = $parameters['Department'];
        $ts->ts_start = $parameters['Start'];
        $ts->ts_end = $parameters['End'];
        $ts->ts_cost = $parameters['Cost'];
        $ts->ts_created_by = 2;//logged in user
        $ts->ts_status = 1;//not submitted //2 submitted/pending 3//canceled //4 approved
        $year  = new Year();
        $yr = $year->createYear(date('Y'));
        $ts->ts_year = $yr->id;//date('Y');//current year
        $ts->save();
        return true;
    }

}
