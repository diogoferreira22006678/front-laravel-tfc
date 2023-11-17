<?php
namespace App\Api;
/* this class is a extension of the WALApi class */

class CoreApi extends BaseApi {

    protected $base_url = 'https://secure.ensinolusofona.pt/dados-publicos-academicos/resources/';

    /*
        POST /GetCourseGroupings {}
        POST /GetCoursesByGrouping {degreeCode: xxx}
        POST /GetCourseDetail {language: 'PT', courseCode: xxx, schoolYear: xxx}
    */

    public function getCourseGroupings(){
        return $this->post('GetCourseGroupings');
    }

    public function getCoursesByGrouping($degreeCode){
        return $this->post('GetCoursesByGrouping', ['degreeCode' => $degreeCode]);
    }

    public function getCourseDetail($courseCode, $schoolYear){
        return $this->post('GetCourseDetail', ['language' => 'PT', 'courseCode' => $courseCode, 'schoolYear'  => $schoolYear]);
    }
}