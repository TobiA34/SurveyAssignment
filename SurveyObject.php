<?php

//    var $survey;
//    $_SESSION['survey'] = SurveyObject;


    class SurveyObject {

      var $title;
      var $instructions;
      var $survey_type;
      var $questions = [];

        public function setTitle($title){
            $this->title = $title;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setInstructions($instructions){
            $this->instructions = $instructions;
        }

        public function getInstructions() {
            return $this->instructions;
        }

        public function setSurveyType($survey_type){
            $this->survey_type = $survey_type;
        }

       public function getSurveyType() {
            return $this->survey_type;
        }

        public function setQuestions($question) {
            array_push($this->questions, $question);
        }

        public function getQuestions() {
            return $this->questions;
        }

    }


    class SurveyQuestionsObject{

        var $questions = [];

        public function getQuestions() {
            return $this->questions;
        }

        public function addQuestion($question){
            array_push($this->questions, $question);
        }
    }
?>