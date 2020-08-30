<?php 

header("Content-Type:text/html; charset=utf-8");
require('PDO_data_to_db.php');

$type = ['week','72h'];
$url_week = file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-ED7050C5-A1A2-4409-B999-A4CCC6F4AFBB&elementName=MinT,MaxT,Wx,PoP12h');
$url_72h = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-ED7050C5-A1A2-4409-B999-A4CCC6F4AFBB&elementName=Wx,T,AT,PoP6h';

//main function
getJson($url_72h,'72h');


function getJson($url,$type){
    $json = file_get_contents($url);
    $data = json_decode($json,true);
    
    switch($type){
        case 'week':
            $data_location = $data['records']['locations'][0]['location'];
            getWeatherWeek($data_location);
        break;

        case '72h':
            $data_location = $data['records']['locations'][0]['location'];
            getWeatherThreeDays($data_location);
        break;

        default:
            echo ("No such function");

    }
        

}



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
                        //addData($list);
                        var_dump($list);                
                break;
                }
                
            }
            
        }
        echo "<hr>";
        $list = array();
        
    }
}


function getWeatherThreeDays($data){

    var_dump($data);
    // $list = [];

    // foreach($data as $location){

    //     $list['location'] = $location['locationName'];
    //     foreach($location['weatherElement'] as $name){

    //         $list['elementName'] = $name['elementName'];
    //         foreach($name['time'] as $time){

    //             $list['startTime'] = $time['startTime'];

    //             foreach($time['elementValue'] as $value){
    //                 $v = $value['value'];
    //                 if(is_numeric($v) || $v == " ")
    //                     $v= intval($v);
                    
    //                     $list['value'] = $v;

    //                     //do upload here
    //                     //addData($list);
    //                     var_dump($list);                
    //             break;
    //             }
                
    //         }
            
    //     }
    //     echo "<hr>";
    //     $list = array();
        
    // }
}



?>