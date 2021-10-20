<?php

namespace App\Classes;

trait Tabulate
{
    public function scopeFiltered($query)
    {
        $query->tabulateQuery();

        if ($searchTerm = request()->input('search.value')) $query->searchQuery($searchTerm);

        return $query;
    }

    public function scopeTabulated($query)
    {
        return $query->filtered()
            ->take(request()->input('length'))
            ->skip(request()->input('start'))
            ->orderBy(...$this->getOrderBy())
        ;
    }

    public function scopeTabulateQuery($query)
    {
        return $query;
    }

    public function scopeSearchQuery($query, $searchTerm)
    {
        return $query;
    }

    private function getOrderBy()
    {
        return [request()->input('order.0.column'), request()->input('order.0.dir')];
    }
}
