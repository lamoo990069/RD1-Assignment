<?php 

header("Content-Type:text/html; charset=utf-8");
require('PDO_data_to_db.php');

//get cwb_api data
$json = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-ED7050C5-A1A2-4409-B999-A4CCC6F4AFBB&elementName=MinT,MaxT,Wx,PoP12h');
$data = json_decode($json,true);
$data_location = $data['records']['locations'][0]['location'];



getWeatherWeek($data_location);

function addData($data){
    $week_pod = new cwbPDO();
    $week_pod->add('weather_week',$data);
}

//grab data
function getWeatherWeek($data){

    $list = [];

    foreach($data as $location){

        $list['location'] = $location['locationName'];
        foreach($location['weatherElement'] as $name){

            $list['elementName'] = $name['elementName'];
            foreach($name['time'] as $time){

                $list['startTime'] = $time['startTime'];

                foreach($time['elementValue'] as $value){
                    $v = $value['value'];
                    if(is_numeric($v) || $v == " ")
                        $v= intval($v);
                    
                        $list['value'] = $v;

                        //do upload here
                        addData($list);                
                break;
                }
                
            }
            
        }
        echo "<hr>";
        $list = array();
        
    }
}






?>