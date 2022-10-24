<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingScheduleController extends Controller
{
    public function __construct()
    {
        $this->employee = new Employee();
        $this->user = new User();
        $this->schedule = new TrainingSchedule();
    }

    public function createSchedule(Request $request)
    {
        $this->validate($request, [
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
            'Cost' => 'required',
        ]);
        $parameters = $request->all();
        $result = $this->schedule->createSchedule($parameters);
        if ($result) {
            return response()->json("Training schedule created successfully", 200);
        } else {
            return response()->json("Something went wrong", 500);
        }
    }


    public function createApprovedTraining(Request $request)
    {
        $this->validate($request, [
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
            'Cost' => 'required',
            'Facilitator' => 'required',
        ]);
        $parameters = $request->all();
        $result = $this->schedule->createApprovedTraining($parameters);
        $schedules = $this->schedule->getApprovedSchedules(0);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }

    public function getSchedules(Request $request, $period)
    {
        //$parameters= $request->all();
        $schedules = $this->schedule->getSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }

    public function submitSchedule (Request $request){
        $this->validate($request, [
            'schedules' => 'required',
        ]);
        $parameters= $request->all();
        $schedules = $this->schedule->submitSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }

    public function approveSchedule (Request $request){
        $this->validate($request, [
            'schedules' => 'required',
        ]);
        $parameters= $request->all();
        $schedules = $this->schedule->approveSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvedBy;
        }
        return response()->json($schedules, 200);
    }

    public function declineSchedule (Request $request){
        $this->validate($request, [
            'schedules' => 'required',
        ]);
        $parameters= $request->all();
        $schedules = $this->schedule->declineSchedule($parameters);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->approvedBy;
        }
        return response()->json($schedules, 200);
    }

    public function updateSchedule(Request $request)
    {
        $this->validate($request, [
            'id'=>'required',
            'Title' => 'required',
            'Description' => 'required',
            'Department' => 'required',
            'TypeofTraining' => 'required',
            'Start' => 'required',
            'End' => 'required',
            'Cost' => 'required',
        ]);
        $parameters = $request->all();
        $result = $this->schedule->updateSchedule($parameters);
        if ($result) {
            return response()->json("Training schedule updated successfully", 200);
        } else {
            return response()->json("Something went wrong",  500);
        }
    }

    public function getApprovedSchedules(Request $request, $period)
    {
        //$parameters= $request->all();
        $schedules = $this->schedule->getApprovedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }



    public function getSubmittedSchedules(Request $request, $period){
        $schedules = $this->schedule->getSubmittedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
        }
        return response()->json($schedules, 200);
    }


    public function getCompletedSchedules($period=0){
        $schedules = $this->schedule->getCompletedSchedules($period);
        foreach ($schedules as $schedule) {
            $schedule->createdBy;
            $schedule->year;
            $schedule->department;
            $schedule->files;
            $schedule->nominees;
            $schedule->ts_nominees =  count($schedule->nominees);
            foreach ($schedule->files as $file)
            {
                $file->filepath = url("/assets/archive/resources/" . $file->filenames);
            }
        }
        return response()->json($schedules, 200);
    }





}
