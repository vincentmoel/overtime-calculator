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
        $overtimeGroups = OvertimeGroup::where('user_id', auth()->user()->id)->groupBy('month', 'year')->get();
        return view('overtime.index', [
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
        $config = Config::where('functionality', 'in-form')->get();

        return view('overtime.create', [
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

        $transportMoney = Config::where('slug','transport_money')->first()->value;
        $mealMoney = Config::where('slug','meal_money')->first()->value;

        foreach (json_decode($request->json) as $detail) {
            $overtimeGroup = OvertimeGroup::create([
                "user_id"   => auth()->user()->id,
                "month"     => $request->month,
                "year"      => $request->year,
                "name"      => $detail->name,
                "transport" => $detail->transport_money ? $transportMoney : 0,
                "meal"      => $detail->meal_money ? $mealMoney : 0,
                "is_sunday" => $detail->working_hour,
            ]);

            foreach ($detail->overtimes as $overtime) {

                Overtime::create([
                    "overtime_group_id" => $overtimeGroup->id,
                    "from"              => $this->dateConvert($overtime->from),
                    "to"                => $this->dateConvert($overtime->to),
                ]);
            }
        }

        return redirect('/overtimes');
    }

    private function dateConvert($dateString)
    {
        $dateFormat = Config::where('slug','date_format')->first()->value;
        return \DateTime::createFromFormat($dateFormat, $dateString)->format('Y-m-d H:i:s');
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
        $configs = Config::where('functionality', 'in-form')->get();

        $arrOvertimes = [];
        $overtimes = OvertimeGroup::where('month', $overtimeGroup->month)->where('user_id', auth()->user()->id)->get();


        // dd($overtimeGroup);
        foreach ($overtimes as $overtime) {
            $arrTemp = [];
            $arrTemp['id'] = $overtime->id;
            $arrTemp['name'] = $overtime->name;
            $arrTemp['month'] = $overtime->month;
            $arrTemp['year'] = $overtime->year;
            $arrTemp['working_hour'] = $overtime->is_sunday;
            $arrTemp['transport_money'] = $overtime->transport;
            $arrTemp['meal_money'] = $overtime->meal;

            $detailOvertime = Overtime::where('overtime_group_id', $overtime->id)->get();

            $arrOvertimeTemp = [];
            foreach ($detailOvertime as $detail) {
                $arrDetail = [];
                $arrDetail['from'] = $detail->from;
                $arrDetail['to'] = $detail->to;
                array_push($arrOvertimeTemp, $arrDetail);
            }

            $arrTemp['overtimes'] = $arrOvertimeTemp;

            array_push($arrOvertimes, $arrTemp);
        }

        // dd($arrOvertimes);
        return view('overtime.edit', [
            "data"          => $arrOvertimes,
            "configs"       => $configs,
            "dateFormat"    => Config::where('slug','date_format')->first()->value
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
        $this->destroy($overtimeGroup);
        $this->store($request);

        return redirect('/overtimes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OvertimeGroup  $overtimeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OvertimeGroup $overtimeGroup)
    {
        // $overtimeGroup->delete();
        $overtimes = OvertimeGroup::where('month', $overtimeGroup->month)->pluck('id');

        Overtime::whereIn('overtime_group_id', $overtimes)->delete();
        OvertimeGroup::whereIn('id', $overtimes)->delete();

        return redirect('/overtimes');
    }


    public function result($month, $year)
    {
        $overtimeGroups = OvertimeGroup::where('user_id', auth()->user()->id)
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        $overtimeMoneyPerHour = Config::where('slug', 'money-per-hour')->first();


        $arrOvertimes = array();

        // dd($overtimes[0]->overtimes[0]->to);

        $totalMoney = 0;
        $totalAdditionalMoney = 0;
        foreach ($overtimeGroups as $overtimeGroup) {
            $mappedOvertime = array();

            $mappedOvertime['name'] = $overtimeGroup->name;
            $mappedOvertime['detail'] = $this->getOvertimeDetail($overtimeGroup);
            $totalOvertime = $this->getTotalTime($overtimeGroup->overtimes, $overtimeGroup->is_sunday);
            $mappedOvertime['overtime'] = gmdate("H:i:s", $totalOvertime);
            $mappedOvertime['money'] = $this->getTotalOvertimeMoney($overtimeMoneyPerHour->value, $totalOvertime, $overtimeGroup->transport, $overtimeGroup->meal);
            $totalMoney += $mappedOvertime['money'];
            $mappedOvertime['transport'] = $overtimeGroup->transport;
            $mappedOvertime['meal'] = $overtimeGroup->meal;
            $totalAdditionalMoney += ($mappedOvertime['transport'] + $mappedOvertime['meal']);
            array_push($arrOvertimes, $mappedOvertime);
        }

        $informations = array();
        $informations['period'] = $overtimeGroups[0]->month . " " . $overtimeGroups[0]->year;
        $informations['name']   = $overtimeGroups[0]->user->name;
        return view('result', [
            'informations'          => $informations,
            'overtimes'             => $arrOvertimes,
            'totalMoney'    => $totalMoney,
        ]);
    }

    public function getOvertimeDetail($overtimeGroup)
    {
        $arrDetails = array();
        foreach ($overtimeGroup->overtimes as $detail) {
            $mappedDetail = array();
            $mappedDetail['from'] = $detail->from;
            $mappedDetail['to'] = $detail->to;
            array_push($arrDetails, $mappedDetail);
        }
        return $arrDetails;
    }

    public function getTotalTime($overtimeData, $isSunday)
    {
        $totalTime = 0;
        foreach ($overtimeData as $overtime) {
            $time = (strtotime($overtime->to) - strtotime($overtime->from));
            $totalTime += $time;
        }

        if ($isSunday) {
            $workingHour = Config::where('slug', 'working_hour')->first();
            // dd($totalTime - ($workingHour->value*3600));
            $totalTime -= ($workingHour->value * 3600);
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
        $config = Config::where('functionality', 'in-form')->get();

        return view('overtime.eventfield', [
            "configs"        => $config,
            "increment"      => $increment
        ]);
    }

    public function addOvertime()
    {
        return view('overtime.timefield');
    }
}
