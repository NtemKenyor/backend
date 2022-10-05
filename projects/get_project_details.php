<?php

include "../the_connector/connect_area.php";
include "../users/get_users.php";
//include "hashing/all_hash_algo.php";
include "../sanitizer/clean_up.php";
include "../generator/generator.php";
include "../publicity/mailer.php";
include "get_project.php";

$array = ["status"=>"false", "msg"=>"No possible connection"];
if(isset($_POST["project_name"])){
    if( isset($_POST["user_id"]) ){
        // $project_description = cleaner_4_DB($_POST["project_description"]);
        // $type = isset($_POST["type"]) ? cleaner_4_DB($_POST["type"]) : "private"; 
        // $project_settings = isset($_POST["project_settings"]) ? cleaner_4_DB($_POST["project_settings"]) : ""; 
        // $addon = isset($_POST["addon"]) ? cleaner_4_DB($_POST["addon"]) : "";
        // $date = date('Y-m-d H:i:s');
        // $date_updated = date('Y-m-d H:i:s');

        // $project_location = $project_name . generate_faster() . '.html';

        //$project_path = '../../storage/projects/' . $project_location ;
        //$project_content = $_POST["project_content"];
        $user_id = cleaner_4_DB($_POST["user_id"]);
        $project_name = cleaner_4_DB($_POST["project_name"]);

        $array = array();
        $project_already = 0;

        //echo $project_name;

        $project_already = num_count_user_project($connect, $project_name, $user_id);
        //echo $user_already;
        if( $project_already == 1){
            //$array = ["status"=>"false", "msg"=>"This project already exist."];
            $project = get_projects_details_by_name($connect, $project_name);
            $array = ["status"=>"true", "project"=>$project, "msg"=>"Successfully loaded project details."];
        }else if($project_already < 1 ){
            $array = ["status"=>"false", "msg"=>"This project does not exist."];
        }else{
            $array = ["status"=>"false", "msg"=>"You may have entered invalid details."];
        }
    }else{
        $array = ["status"=>"false", "msg"=>"Invalid User: Looks like you are not logged in."];
    }
    
}

echo json_encode($array);


?>