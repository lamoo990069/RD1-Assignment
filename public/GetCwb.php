<?php 

header("Content-Type:text/html; charset=utf-8");


$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-ED7050C5-A1A2-4409-B999-A4CCC6F4AFBB&elementName=MinT,MaxT,Wx,PoP12h');
$data = json_decode($json,true);
$data_location = $data['records']['locations'][0]['location'];


foreach($data_location as $location_k => $location_v){
    echo "location: ".$location_v['locationName'];
    echo "<br>";
    foreach($location_v['weatherElement'] as $name_k => $name_v){
        echo "elementName: ".$name_v['elementName'];
        echo "<hr>";
            foreach($name_v['time'] as $time_k => $time_v){
                echo $time_k;
                echo $time_v['startTime']." ~ ".$time_v['endTime'];
                echo'<br>';
                foreach($time_v['elementValue'] as $value_k => $value_v){
                    $value = $value_v['value'];
                    if(is_numeric($value) || $value == " ")
                        $value = intval($value_v['value']);
                    
                    echo ($value);         
                    echo"<br>-----------------------<br>";                  
                break;
                }
                
            }
        
    }
    echo "<hr>";
}


?>