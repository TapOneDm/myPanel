<?php

namespace common\components;

class Helper {
    
    function diff(array $array1, array $array2): array {
        $result = $array1;
        foreach ($result as $key => $values){
            if( array_key_exists($key, $array2)){
                $result[$key] = array_diff($values, $array2[$key]);
                if($result[$key] === []){
                    unset($result[$key]);
                }
            }
        }
        return $result;
    }
}  