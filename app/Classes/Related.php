<?php

namespace App\Classes;

trait Related
{
    public function addRelation($id)
    {
        if ($this->id == $id) return false;

        $min = min($this->id, $id);
        $max = max($this->id, $id);

        $relation = Related::firstOrCreate([
            ['related1', $min],
            ['related2', $max],
            ['type', self::class]
        ]);

        $relation->increment('times');
    }

    public static function getRelatedWith($ids, $limit=10)
    {
        return self::findRelated($ids, $limit);
    }

    public function getRelated($limit=10)
    {
        return self::findRelated([$this->id], $limit);
    }

    private static function findRelated($ids, $limit)
    {
        $key = 'related-' .\Str::slug(self::class) . '-' . implode('.', $ids);

        if (\Cache::has($key)) return \Cache::get($key);

        $method = (is_array($ids)) ? 'whereIn' : 'where';

        $related1 = \DB::table('related')->select('related2_id as id')
            ->$method('related1_id', $ids)
            ->where('type', self::class)
            ->orderBy('times', 'desc')
            ->limit($limit*2)
            ->get()
        ;

        $related2 = \DB::table('related')->select('related1_id as id')
            ->$method('related2_id', $ids)
            ->where('type', self::class)
            ->orderBy('times', 'desc')
            ->limit($limit*2)
            ->get()
        ;

        $relatedAll = $related1->merge($related2);
        $ids = $relatedAll->pluck('id')->toArray();

        $related = self::whereIn('id', $ids)
            ->orderByRaw('FIND_IN_SET(id, "'.implode(',',  $ids) . '")')
            ->limit($limit)
        ;

        if ((is_array($ids))) {
            $related->whereNotIn('id', $ids);
        } else {
            $related->where('id', '!=', $ids);
        }

        $related = $related->get();

        \Cache::put($key, $related, 60 * 60 * 24);

        return $related;
    }
}