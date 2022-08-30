<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Overtime;
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
        $request->validate([
            'month' => 'required',
            'year'  => 'required|numeric',
            'json'  => 'required'
        ]);

        foreach(json_decode($request->json) as $detail)
        {
            $overtimeGroup = OvertimeGroup::create([
                "user_id"   => auth()->user()->id,
                "month"     => $request->month,
                "year"      => $request->year,
                "name"      => $detail->name,
                "transport" => $detail->transport_money ? 7000 : 0 ,
                "meal"      => $detail->meal_money ? 5000 : 0,
                "is_sunday" => $detail->working_hour,
            ]);

            foreach($detail->overtimes as $overtime)
            {
                Overtime::create([
                    "overtime_group_id" => $overtimeGroup->id,
                    "from"              => $overtime->from,
                    "to"                => $overtime->to,
                ]);
            }
        }

        return redirect('/overtimes');
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
        $configs = Config::where('functionality','in-form')->get();

        $arrOvertimes = [];
        $overtimes = OvertimeGroup::where('month',$overtimeGroup->month)->get();


        // dd($overtimeGroup);
        foreach($overtimes as $overtime)
        {
            $arrTemp = [];
            $arrTemp['name'] = $overtime->name;
            $arrTemp['month'] = $overtime->month;
            $arrTemp['year'] = $overtime->year;
            $arrTemp['working_hour'] = $overtime->is_sunday;
            $arrTemp['transport_money'] = $overtime->transport;
            $arrTemp['meal_money'] = $overtime->meal;

            $detailOvertime = Overtime::where('overtime_group_id',$overtime->id)->get();

            $arrOvertimeTemp = [];
            foreach($detailOvertime as $detail)
            {
                $arrDetail = [];
                $arrDetail['from'] = $detail->from;
                $arrDetail['to'] = $detail->to;
                array_push($arrOvertimeTemp,$arrDetail);
            }

            $arrTemp['overtimes'] = $arrOvertimeTemp;

            array_push($arrOvertimes, $arrTemp);
        }

        // dd($arrOvertimes);
        return view('overtime.edit',[
            "data"      => $arrOvertimes,
            "configs"    => $configs
        ]);
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
            $workingHour = Config::where('slug','working_hour')->first();
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

    public function addEvent($increment)
    {
        $config = Config::where('functionality','in-form')->get();

        return view('overtime.eventfield',[
            "configs"        => $config,
            "increment"      => $increment
        ]);
    }
    
    public function addOvertime()
    {
        return view('overtime.timefield');
    }
}
