<?php
final class DueDateCalculator{
    function isWorkingDay(DateTime $datetime){

        $julian_date = unixtojd($datetime->getTimestamp());
        $julian_dayofweek = jddayofweek($julian_date, 0);

        if($julian_dayofweek > 0 && $julian_dayofweek < 6){
            return true;
        }else{
            return false;
        }
    }
    function isWorkingHours(DateTime $datetime){
        if($this->isWorkingDay($datetime)){
            $hour = $datetime->format('G');
            if($hour >= 9 && $hour <= 17){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
        
    }
}
?>