<?php

namespace App\Classes;

trait Unite
{

    public function scopeLeftUnite($query, $relation)
    {
        return $query->unite($relation, true);
    }

    public function scopeUnite($query, $relation, $left=false)
    {
        //if ($query->isUnited()) return $query;

        $cardinality = class_basename(get_class($this->$relation()));

        if ($cardinality == 'BelongsToMany') {
            $query->uniteRelated($relation, $left);
        } elseif ($cardinality == 'MorphMany') {
            $query->uniteMorphMany($relation, $left);
        } elseif ($cardinality ==  in_array($cardinality, ['HasMany', 'HasOne'])) {
            $query->uniteHasMany($relation, $left); //TODO: testear
        } else {
            $query->uniteSimple($relation, $left);
        }

        return $query;
    }

    public function scopeUniteSimple($query, $relation, $left)
    {
        $join = ($left)?'leftJoin':'join';
        $relationTable = $this->$relation()->getRelated()->getTable();
        $ownerKey = $this->$relation()->getQualifiedOwnerKeyName();
        $foreignKey = $this->$relation()->getQualifiedForeignKeyName();
        $query->$join($relationTable, $ownerKey, '=', $foreignKey);
    }

    public function scopeUniteHasMany($query, $relation, $left)
    {
        $join = ($left)?'leftJoin':'join';
        $relationTable = $this->$relation()->getRelated()->getTable();
        
        $query->$join($relationTable, function ($join) use ($relation) {
            $ownerKey = $this->getTable().'.'.$this->primaryKey;
            $foreignKey = $this->$relation()->getQualifiedForeignKeyName();
            $join->on($ownerKey, '=', $foreignKey);
        });
    }

    public function scopeUniteRelated($query, $relation, $left)
    {
        $join = ($left)?'leftJoin':'join';
        $pivot = $this->$relation()->getTable();
        $related = $this->$relation()->getRelated()->getTable();
        $pivotOwnKey = $this->$relation()->getQualifiedForeignPivotKeyName();
        $pivotForeingKey = $this->$relation()->getQualifiedRelatedPivotKeyName();
        $ownerKey = $this->$relation()->getQualifiedParentKeyName();
        $foreignKey = $this->$relation()->getRelated()->getQualifiedKeyName();
        $query->$join($pivot, $pivotOwnKey, '=', $ownerKey);
        $query->$join($related, $pivotForeingKey, '=', $foreignKey);
    }

    public function scopeUniteMorphMany($query, $relation, $left)
    {
        $join = ($left)?'leftJoin':'join';
        $relationTable = $this->$relation()->getRelated()->getTable();
        

        $query->$join($relationTable, function ($join) use ($relation) {
            $ownerKey = $this->getTable().'.'.$this->primaryKey;
            $foreignKey = $this->$relation()->getQualifiedForeignKeyName();
            $morphType = $this->$relation()->getQualifiedMorphType();
            $morphClass = $this->$relation()->getMorphClass();
            $join->on($ownerKey, '=', $foreignKey)
                 ->where($morphType, $morphClass);
        });
    }

    public function scopeIsUnited($query, $relation)
    {
        $relationTable = $this->$relation()->getRelated()->getTable();
        $joins = $query->getQuery()->joins;
        if($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $relationTable) {
                return true;
            }
        }
        return false;
    }

}