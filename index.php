<?php

//     Provide several examples that call your function and demonstrate that it works.
// Provide the average runtime and space complexity (memory usage), and worst-case runtime
// and space complexity for your solution, and a short explanation as to why.
// State any assumptions you make for your solution.
// Question:
// Given an access log for a feature, output the customer ids of repeat customers who have visited
// on 3 or
// more consecutive days. Each line of the access log is tab delimited with two fields: the
// timestamp of
// when the customer visited, and the customer id (a 10-byte string). The feature writes an entry to
// the log
// file as it gets the hits. Below is an example log file.


$log1 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
09-Jun-2012 1:00 AM 1ABCDEFGHI
09-Jun-2012 9:23 AM 3ABCDEFGHI
10-Jun-2012 1:00 AM 2ABCDEFGHI
10-Jun-2012 2:03 AM 2ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
10-Jun-2012 7:23 AM 3ABCDEFGHI
10-Jun-2012 9:23 AM 3ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 2:12 AM 2ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI
12-Jun-2012 10:21PM 1ABCDEFGHI';

$log2 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
09-Jun-2012 2:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log3 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
09-Jun-2012 1:00 AM 1ABCDEFGHI
09-Jun-2012 2:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log4 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
09-Jun-2012 2:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log5 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
12-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
09-Jun-2012 2:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log6 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
12-Jun-2012 1:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
09-Jun-2012 2:00 AM 1ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log7 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
12-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 5:00 AM 1ABCDEFGHI
08-Jun-2012 2:00 AM 1ABCDEFGHI
10-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
$log8 = '08-Jun-2012 1:00 AM 4ABCDEFGHI
12-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 5:00 AM 1ABCDEFGHI
09-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 1:00 AM 1ABCDEFGHI
13-Jun-2012 1:00 AM 1ABCDEFGHI
11-Jun-2012 8:23 AM 3ABCDEFGHI';
//test cases
echo get_repeated_id($log1)."<br>";
echo get_repeated_id($log2)."<br>";
echo get_repeated_id($log3)."<br>";
echo get_repeated_id($log4)."<br>";
echo get_repeated_id($log5)."<br>";
echo get_repeated_id($log6)."<br>";
echo get_repeated_id($log7)."<br>";
echo get_repeated_id($log8)."<br>";

//function to get ids with 3 consecutive date entries
function get_repeated_id($log)
{
    $arr = explode("\n", $log);//breaking the log string by line and storing each line as an element in the array
    $arr2 = array();//array to store parts of each line
    $assoc_arr = array();//array to store key and value array pairs
    $result = array();//array to strore result ids

    //looping through each line of the string and storing its parts into a 2D array
    for ($i = 0; $i < count($arr); $i++) {
        $arr2[$i] = explode(" ", $arr[$i]);
    }

    //looping through the 2D array and storing ids as keys and their entry date timestamps as value arrays in the associative array
    for ($i = 0; $i < count($arr2); $i++) {

        $date = strtotime($arr2[$i][0]);//converting the string date into timestamp (This will be done for date entry in each line)
        
        $id = $arr2[$i][count($arr2[$i]) - 1];//id of that same line

        //if the id(key) isn't already present in assoc_arr,creating the id as key and creating a value array with entry date timestamp as an element 
        if (!array_key_exists($id, $assoc_arr)) {
            $assoc_arr[$id] = array($date);
        } 
        //if the id(key) is already present in assoc_arr,then adding the entry date timestamp into its corresponding value array
        else {
            array_push($assoc_arr[$id], $date);
        }
    }

    //loop for removing duplicate entries and sorting
    foreach ($assoc_arr as $id => $dates) {
        //removing duplicate date timestamps as we don't need same day entries
        $assoc_arr[$id] = array_unique($dates);
        //sorting the value arrays in ascending order
        sort($assoc_arr[$id]);
    }

    //loop for checking if a id has 3 consecutive date entries
    foreach ($assoc_arr as $id => $dates) {

        if (count($dates) >= 3) {//targeting only the ids with 3 or more dates

            for ($i = 0; $i < count($dates) - 2; $i++) {
                //checking if the date of 3 consecutive indexes is actually 3 consecutive days and targetting those ids
                if (strtotime("+1 day", $dates[$i]) == $dates[$i + 1] && strtotime("+2 day", $dates[$i]) == $dates[$i + 2]) {
                    //pushing the targetted id into the result array if its not already there
                    /*this is neccessary because if an id has more than 3 consecutive date entries then the id will be pushed into the
                    result array for more than one time*/
                    if (!in_array($id, $result)) {
                        array_push($result, $id);
                    }
                }
            }
        }
    }
    //finally returning the result ids
    if(empty($result)){
        return "no id with 3 consecutive entries";
    }else{
        $repeated_ids='';
        for($i=0;$i<count($result);$i++){
            $repeated_ids .=($i+1).'->'.$result[$i].' ';
        }
        return $repeated_ids;
    }

}
