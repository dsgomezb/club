<?php

namespace App\Classes;

trait QueryRequest
{
	public function scopeWhenRequest($query, $param, $callback)
    {
        $params = is_array($param) ? $param : [$param];

        if (request()->has($params)) {
            $query = $callback($query, ...array_values(request()->only($params)));
        }

        return $query;
    }

    public function scopeWhereRequest($query, $param)
    {
        if (request()->has($param)) {
        	if (is_array(request()->input($param))) {
        		$query->whereHas($param, function ($query) use ($param) {
        			$query->whereIn('id', request()->input($param));
        		});
        	} else {
            	$query->where($param, request()->input($param));
        	}
        }

        return $query;
    }

    public function scopeOrWhereRequest($query, $param)
    {
        if (request()->has($param)) {
        	if (is_array(request()->input($param))) {
        		$query->orWhereHas($param, function ($query) use ($param) {
        			$query->orWhereIn('id', request()->input($param));
        		});
        	} else {
            	$query->orWhere($param, request()->input($param));
        	}
        }

        return $query;
    }
}
