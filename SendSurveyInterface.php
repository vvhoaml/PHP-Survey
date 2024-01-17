<?php
interface SendSurveyInterface {
    public function insertData($user_id, $mark, $text);
}