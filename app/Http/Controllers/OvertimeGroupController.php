<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\OvertimeGroup;
use Illuminate\Http\Request;

class OvertimeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overtimeGroups = OvertimeGroup::where('user_id',auth()->user()->id)->groupBy('month','year')->get();
        return view('overtime.index',[
            "overtimeGroups" => $overtimeGroups,
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $config = Config::where('functionality','in-form')->get();

        return view('overtime.create',[
            "configs"        => $config
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OvertimeGroup  $overtimeGroup
     * @return \Illuminate\Http\Response
     */
    public function show(OvertimeGroup $overtimeGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OvertimeGroup  $overtimeGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OvertimeGroup $overtimeGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OvertimeGroup  $overtimeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OvertimeGroup $overtimeGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OvertimeGroup  $overtimeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OvertimeGroup $overtimeGroup)
    {
        //
    }


    public function result()
    {
        $overtimeGroups = OvertimeGroup::where('user_id',1)
                            ->where('month',"Agustus")
                            ->where('year',2022)
                            ->get();
        
        $overtimeMoneyPerHour = Config::where('slug','money-per-hour')->first();

        
        $arrOvertimes = array();

        // dd($overtimes[0]->overtimes[0]->to);

        foreach($overtimeGroups as $overtimeGroup)
        {
            $mappedOvertime = array();

            $mappedOvertime['name'] = $overtimeGroup->name;
            $mappedOvertime['detail'] = $this->getOvertimeDetail($overtimeGroup);
            $totalOvertime = $this->getTotalTime($overtimeGroup->overtimes, $overtimeGroup->is_sunday);
            $mappedOvertime['overtime'] = gmdate("H:i:s",$totalOvertime);
            $mappedOvertime['money'] = $this->getTotalOvertimeMoney($overtimeMoneyPerHour->value, $totalOvertime,$overtimeGroup->transport,$overtimeGroup->meal);
            $mappedOvertime['transport'] = $overtimeGroup->transport;
            $mappedOvertime['meal'] = $overtimeGroup->meal;

            array_push($arrOvertimes,$mappedOvertime);
        }

        $informations = array();
        $informations['period'] = $overtimeGroups[0]->month ." ". $overtimeGroups[0]->year;
        $informations['name']   = $overtimeGroups[0]->user->name;
        return view('welcome',[
            'informations'  => $informations,
            'overtimes'     => $arrOvertimes
        ]);
    }

    public function getOvertimeDetail($overtimeGroup)
    {
        $arrDetails = array();
        foreach($overtimeGroup->overtimes as $detail)
        {
            $mappedDetail = array();
            $mappedDetail['from'] = $detail->from;
            $mappedDetail['to'] = $detail->to;
            array_push($arrDetails,$mappedDetail);
        }
        return $arrDetails;
    }

    public function getTotalTime($overtimeData, $isSunday)
    {
        $totalTime = 0;
        foreach($overtimeData as $overtime)
        {
            $time = (strtotime($overtime->to) - strtotime($overtime->from));
            $totalTime += $time;
        }
        
        if($isSunday)
        {
            $workingHour = Config::where('slug','working-hour')->first();
            // dd($totalTime - ($workingHour->value*3600));
            $totalTime -= ($workingHour->value*3600);
        }

        return $totalTime;
    }

    public function getTotalOvertimeMoney($overtimeMoneyPerHour, $totalOvertime, $transportMoney, $mealMoney)
    {
        $overtimeMoney = floor(($overtimeMoneyPerHour / 3600) * $totalOvertime);
        return $overtimeMoney + $transportMoney + $mealMoney; 
    }

    public function addEvent()
    {
        $config = Config::where('functionality','in-form')->get();

        return view('overtime.eventfield',[
            "configs"        => $config
        ]);
    }
    
    public function addOvertime()
    {
        return view('overtime.timefield');
    }
}
