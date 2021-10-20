<?php

namespace App\Classes;

trait Searchable
{

    private function getSearchKey()
    {
        return $this->getTable() . '.id';
    }

    public function scopeAdvancedSearch($query, $keywords, $fields, $callback=null)
    {
        $keywords = $this->prepareSearch($keywords);

        $ids = strstr($keywords, ' ')
                ? $this->multipleSearch($keywords, $fields, $callback)
                : $this->simpleSearch($keywords, $fields, $callback);

        return $query->whereIn($this->getSearchKey(), $ids)->orderByRaw("FIND_IN_SET(".$this->getSearchKey().", '".implode(',', $ids)."')");
    }

    public function simpleSearch ($keyword, $fields, $callback=null)
    {
        $fields = (is_array($fields))?$fields:array($fields);
        $ids = [0];

        foreach ($fields as $field) {
            $query = self::select($this->getSearchKey())->whereNotIn($this->getSearchKey(), $ids)->where($field, 'like', "%$keyword%");
            if ($callback) $callback($query);
            $result = $query->pluck($this->getSearchKey())->toArray();
            if($result) $ids = array_merge($ids, $result);
        }

        return array_unique($ids);
    }
    
    public function multipleSearch ($keywords, $fields, $callback=null)
    {
        $andLike = ' LIKE "%'.str_replace(' ', '%" AND colum LIKE "%', $keywords).'%"';
        $orLike = ' LIKE "%'.str_replace(' ', '%" OR colum LIKE "%', $keywords).'%"';

        $fields = (is_array($fields))?$fields:array($fields);
        $ids = [0];

        //busqueda con and
        foreach ($fields as $field) {
            $serchTerm = str_replace('colum', $field, $andLike);
            $query = self::select($this->getSearchKey())->whereNotIn($this->getSearchKey(), $ids)->whereRaw($field.$serchTerm);
            if ($callback) $callback($query);
            $result = $query->pluck($this->getSearchKey())->toArray();
            if($result) $ids = array_merge($ids, $result);
        }

        //busqueda con or
        foreach ($fields as $field) {
            $serchTerm = str_replace('colum', $field, $orLike);
            $query = self::select($this->getSearchKey())->whereNotIn($this->getSearchKey(), $ids)->whereRaw($field.$serchTerm);
            if ($callback) $callback($query);
            $result = $query->pluck($this->getSearchKey())->toArray();
            if($result) $ids = array_merge($ids, $result);
        }

        return array_unique($ids);
    }

    private function prepareSearch ($keywords)
    {
        $keywords = strtolower($keywords);
        $keywords = preg_replace('/\b(el|la|los|las|un|una|unos|unas|a|al|de|del|con|por|para|que|en)\b/i', '', $keywords);
        $keywords = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚüÜñÑ \-]/', '', $keywords);
        $keywords = preg_replace('/ {2,}/', ' ', $keywords);
        return trim($keywords);
    }
}