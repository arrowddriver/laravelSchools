<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function insertSchools(){
        School::truncate();
        for($i = 1; $i < 40001; $i++){
            School::create(["name" => "school" . $i]);
        }
        echo "Ok!";
    }

    public function getSchools(Request $request){
        $search = $request->search;

        if($search == ''){
           $schools = School::orderby('name','asc')->select('id','name')->limit(5)->get();
        }else{
           $schools = School::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($schools as $school){
           $response[] = array(
                "id"=>$school->id,
                "text"=>$school->name
           );
        }
        return response()->json($response);
    }
}
