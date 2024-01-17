<?php
require_once 'SendSurveyInterface.php';

class SendSurvey implements SendSurveyInterface {
    private $db;

    public function __construct(ConnectionInterface $db) {
        $this->db = $db;
    }

    public function insertData($user_id, $mark, $text) {
        $user_id = $this->db->getConnection()->real_escape_string($user_id);
        $text = $this->db->getConnection()->real_escape_string($text);

        $userRepository = new UserRepository($this->db);

        if ($userRepository->userExists($user_id)) {
            $sql = "INSERT INTO surveys (user_id, survey_mark, survey_text) VALUES ('$user_id', '$mark', '$text')";

            if ($this->db->getConnection()->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}