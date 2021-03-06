<?php
final class DueDateCalculator{
    function isWorkingDay(DateTime $datetime){
        //$date = new DateTime($datetime);

        $date = $datetime;
        
        $julian_date = unixtojd($date->getTimestamp());
        $julian_dayofweek = jddayofweek($julian_date, 0);

        if($julian_dayofweek > 0 && $julian_dayofweek < 6){
            return true;
        }else{
            return false;
        }

        
    }
}
?>