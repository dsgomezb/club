<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Calendar;
use App\Http\Controllers\Controller;
use App\User;

class StatisticsController extends Controller
{
	private $optionsHash = [
        1 => ['days' => 7, 'mysqlFunction' => 'DAYOFWEEK', 'calendarFunction' => 'numberToDay'],
        2 => ['days' =>30, 'mysqlFunction' => 'WEEK', 'calendarFunction' => 'numberToWeek'],
        3 => ['days' => 90, 'mysqlFunction' => 'MONTH', 'calendarFunction' => 'numberToMonth'],
        4 => ['days' => 180, 'mysqlFunction' => 'MONTH', 'calendarFunction' => 'numberToMonth'],
        5 => ['days' => 365, 'mysqlFunction' => 'MONTH', 'calendarFunction' => 'numberToMonth'],
    ];

    private $options;
    private $calendar;

    public function __construct(Calendar $calendar)
    {
        request()->validate(['period' => 'required|integer|between:1,5']);
        $this->options = $this->optionsHash[request()->input('period')];
        $this->calendar = $calendar;
    }

    public function users()
    {
        $cacheKey = 'statistics.users.'.request()->input('period');

        if (!$info = \Cache::get($cacheKey)) {
            $info = User::selectRaw('SUM(id) as data, '.$this->options['mysqlFunction'].'(created_at) AS labels')
                ->where('created_at', '>=', now()->subDays($this->options['days']))
                ->groupBy('labels')
                ->orderBy('created_at', 'asc')
                ->get()
                ->toArray()
            ;

            $info = $this->parseData($info);

            \Cache::put($cacheKey, $info, 60 * 60 * 24);
        }

        return $info;
    }

    public function bestSellers()
    {
        $cacheKey = 'statistics.bestSellers.'.request()->input('period');

        if (!$info = \Cache::get($cacheKey)) {
            $info = Item::selectRaw('count(items.id) as sumatoria, products.name')
                ->unite('product')
                ->join('purchases', function ($query) {
                    $query->on('purchases.id', '=', 'items.purchase_id')
                       ->where('purchases.status_id', 2)
                       ->where('purchases.created_at', '>=', now()->subDays($this->options['days']))
                    ;
                })
                ->orderBy('sumatoria', 'desc')
                ->groupBy('items.product_id')
                ->take(5)
                ->get()
            ;

            \Cache::put($cacheKey, $info, 60 * 60 * 24);
        }

        return $info;
    }

    public function unpopulars()
    {
        $cacheKey = 'statistics.unpopulars.'.request()->input('period');

        if (!$info = \Cache::get($cacheKey)) {
            $info = Item::selectRaw('count(items.id) as sumatoria, products.name')
                ->unite('product')
                ->join('purchases', function ($query) {
                    $query->on('purchases.id', '=', 'items.purchase_id')
                       ->where('purchases.status_id', 2)
                       ->where('purchases.created_at', '>=', now()->subDays($this->options['days']))
                    ;
                })
                ->orderBy('sumatoria', 'asc')
                ->groupBy('items.product_id')
                ->take(5)
                ->get()
            ;

            \Cache::put($cacheKey, $info, 60 * 60 * 24);
        }

        return $info;
    }

    public function client()
    {
        $cacheKey = 'statistics.client.'.request()->input('period');

        if (!$info = \Cache::get($cacheKey)) {
            $info = Client::selectRaw('sum(purchases.total) as sumatoria, concat(clients.firstname, " ", clients.lastname) as name')
                ->join('purchases', function ($query) {
                    $query->on('purchases.client_id', '=', 'clients.id')
                       ->where('purchases.status_id', 2)
                       ->where('purchases.created_at', '>=', now()->subDays($this->options['days']))
                    ;
                })
                ->orderBy('sumatoria', 'desc')
                ->groupBy('clients.id')
                ->take(5)
                ->get()
            ;

            \Cache::put($cacheKey, $info, 60 * 60 * 24);

            \Cache::flush();
        }

       return $info;
    }

    public function clientPurchases()
    {
        $cacheKey = 'statistics.client.'.request()->input('period');

        if (!$info = \Cache::get($cacheKey)) {
            $info = Client::selectRaw('count(purchases.id) as sumatoria, concat(clients.firstname, " ", clients.lastname) as name')
                ->join('purchases', function ($query) {
                    $query->on('purchases.client_id', '=', 'clients.id')
                        ->where('purchases.created_at', '>=', now()->subDays($this->options['days']))
                        ->where('purchases.status_id', 2)
                    ;
                })
                ->orderBy('sumatoria', 'desc')
                ->groupBy('clients.id')
                ->take(5)
                ->get()
            ;

            \Cache::put($cacheKey, $info, 60 * 60 * 24);

            \Cache::flush();
        }

        return $info;
    }

    private function parseData($info)
    {
        $data = [];
        $labels = [];
        $calendarFunction = $this->options['calendarFunction'];

        foreach ($info as $item) {
        	$data[] = $item['data'];
            $labels[] =  $this->calendar->$calendarFunction($item['labels']);
        }


        return compact('data', 'labels');
    }
}
