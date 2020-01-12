<?php

namespace Labs\Analytic\Http\Resource\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class DataChartResource
 * @package Labs\Analytic\Http\Resource\Admin
 */
class DataChartResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($item) {
            return $item->count();
        });
        return [
            'total' => $this->count(),
            'data' => $this->getLabels($request)->map(function ($date) use ($data) {
                return $data->has($date) ? $data[$date] : 0;
            }),
            'labels' => $this->getLabels($request)
        ];
    }

    /**a
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    protected function getLabels(Request $request)
    {
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->get('start'));
            $end = Carbon::parse($request->get('end'));
        } else {
            $month = Carbon::now();
            $start = Carbon::parse($month)->startOfMonth();
            $end = Carbon::parse($month)->endOfMonth();
        }


        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->format('Y-m-d');
            $start->addDay();
        }
        return collect($dates);
    }
}
