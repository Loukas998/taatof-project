<?php

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class QueryFilter{
    protected $builder;
    protected $request;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter(array $arr){
        foreach($arr as $key => $value){
            if(method_exists($this, $key)){
                $this->$key($value);
            }
        }

        return $this->builder;
    }// this is called when there is something like this in the url: filter[key]=value&filter[key2]=value2
     // then each key($value) will be called from the class that inherits QueryFilter

    public function apply(Builder $builder){
        $this->builder = $builder;
        foreach($this->request->all() as $key => $value){
            if(method_exists($this, $key)){
                $this->$key($value);
            }
        }

        return $builder;
    }// this will be called when the url contains: key=value&key2=value2
     // then each key(value) first will check if the key in this class or in some extension
     // and call the right key method

    protected function sort($value){
        $sortAttributes = explode(',', $value);
        //dd($sortAttributes);
        $direction = 'asc';

        foreach($sortAttributes as $sortAttribute){
            if(strpos($sortAttribute, '-') === 0){
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }//this is for determining the direction and extracting the actual column name

            if(!in_array($sortAttribute, $this->sortable) &&
                !array_key_exists($sortAttribute, $this->sortable)){
                continue;
            }//this is to check if the attribute exists in the sortable array

            $columnName = $this->sortable[$sortAttribute] ?? null;//the actual column name

            if($columnName == null){
                $columnName = $sortAttribute;
            }//if the name in the url is different from the actual name in the database

            $this->builder->orderBy($columnName, $direction);// finally the query
        }
    }
}