<?php

class Survey {
    private $db;
    private $data;
    private $errors = [];
    private $requiredFields = ['fname', 'lname', 'email', 'age', 'gender', 'nationality', 'rating', 'has_pc'];

    public function __construct(array $data) {
        $this->db = Database::getInstance();
        $this->data = $this->sanitizeData($data);
    }

    private function sanitizeData($data) {
        return array_map(function($item) {
            if (is_array($item)) {
                return array_map([$this, 'sanitizeInput'], $item);
            }
            return $this->sanitizeInput($item);
        }, $data);
    }

    private function sanitizeInput($data) {
        $data = trim($data);
        $data = strip_tags($data);
        return htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public function validate() {
        $this->validateRequired()
             ->validateNames()
             ->validateEmail()
             ->validateAge()
             ->validateGender()
             ->validateNationality()
             ->validateHasPC()
             ->validateRating()
             ->validateHobbies()
             ->validateSuggestions()
             ->checkDuplicates();

        return empty($this->errors);
    }

    private function validateRequired() {
        $missingFields = [];
        foreach ($this->requiredFields as $field) {
            if (!isset($this->data[$field]) || empty($this->data[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            $this->errors['all'] = 'Required fields missing: ' . implode(', ', $missingFields);
        }
        
        return $this;
    }

    private function validateNames() {
        foreach (['fname', 'lname'] as $field) {
            if (isset($this->data[$field])) {
                if (strlen($this->data[$field]) < 1 || strlen($this->data[$field]) > 20) {
                    $this->errors[$field] = ucfirst($field === 'fname' ? 'First' : 'Last') . ' name must be between 1 and 20 characters';
                } elseif (!preg_match('/^[a-zA-Z\s-]+$/', $this->data[$field])) {
                    $this->errors[$field] = ucfirst($field === 'fname' ? 'First' : 'Last') . ' name can only contain letters, spaces, and hyphens';
                }
            }
        }
        return $this;
    }

    private function validateEmail() {
        if (isset($this->data['email']) && !filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Invalid email address';
        }
        return $this;
    }

    private function validateAge() {
        if (isset($this->data['age'])) {
            $age = intval($this->data['age']);
            if ($age < 1 || $age > 100) {
                $this->errors['age'] = 'Age must be between 1 and 99';
            }
        }
        return $this;
    }

    private function validateGender() {
        if (isset($this->data['gender']) && !in_array($this->data['gender'], ['male', 'female'], true)) {
            $this->errors['gender'] = 'Gender must be either male or female';
        }
        return $this;
    }

    private function validateNationality() {
        if (isset($this->data['nationality'])) {
            $result = $this->db->fetch("SELECT id FROM nationalities WHERE name = ?", [$this->data['nationality']]);
            if (!$result) {
                $this->errors['nationality'] = 'Invalid nationality selected';
            }
        }
        return $this;
    }

    private function validateHasPC() {
        if (isset($this->data['has_pc'])) {
            $hasPC = filter_var($this->data['has_pc'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($hasPC === null) {
                $this->errors['has_pc'] = 'Please select whether you have a personal computer';
            }
        }
        return $this;
    }

    private function validateRating() {
        if (isset($this->data['rating'])) {
            $rating = intval($this->data['rating']);
            if ($rating < 1 || $rating > 5) {
                $this->errors['rating'] = 'Rating must be between 1 and 5';
            }
        }
        return $this;
    }

    private function validateHobbies() {
        if (!isset($this->data['hobbies']) || !is_array($this->data['hobbies']) || count($this->data['hobbies']) === 0) {
            $this->errors['hobbies'] = 'Please select at least one hobby';
        } else {
            $validHobbies = $this->db->fetchAll("SELECT name FROM hobbies");
            $validHobbyNames = array_column($validHobbies, 'name');
            $invalidHobbies = array_diff($this->data['hobbies'], $validHobbyNames);
            
            if (!empty($invalidHobbies)) {
                $this->errors['hobbies'] = 'Invalid hobbies selected: ' . implode(', ', $invalidHobbies);
            }
        }
        return $this;
    }

    private function validateSuggestions() {
        if (isset($this->data['suggestions']) && strlen($this->data['suggestions']) > 255) {
            $this->errors['suggestions'] = 'Suggestions must not exceed 255 characters';
        }
        return $this;
    }

    private function checkDuplicates() {
        // Check for duplicate email
        $existingEmail = $this->db->fetch(
            "SELECT id FROM surveys WHERE email = ?",
            [$this->data['email']]
        );
        if ($existingEmail) {
            $this->errors['email'] = 'This email has already been used';
        }

        // Check for duplicate name combination
        $existingNames = $this->db->fetch(
            "SELECT id FROM surveys WHERE fname = ? AND lname = ?",
            [$this->data['fname'], $this->data['lname']]
        );
        if ($existingNames) {
            $this->errors['fname'] = 'This name combination has already been used';
            $this->errors['lname'] = 'This name combination has already been used';
        }

        return $this;
    }

    public function save() {
        try {
            $this->db->beginTransaction();

            // Insert survey data
            $surveyData = [
                'fname' => $this->data['fname'],
                'lname' => $this->data['lname'],
                'email' => $this->data['email'],
                'age' => intval($this->data['age']),
                'gender' => $this->data['gender'],
                'has_pc' => filter_var($this->data['has_pc'], FILTER_VALIDATE_BOOLEAN),
                'nationality_id' => $this->db->fetch(
                    "SELECT id FROM nationalities WHERE name = ?",
                    [$this->data['nationality']]
                )['id'],
                'rating' => intval($this->data['rating']),
                'suggestions' => $this->data['suggestions'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('surveys', $surveyData);
            $surveyId = $this->db->lastInsertId();

            // Insert hobbies
            $hobbyIds = [];
            foreach ($this->data['hobbies'] as $hobbyName) {
                $result = $this->db->fetch("SELECT id FROM hobbies WHERE name = ?", [$hobbyName]);
                if ($result) {
                    $hobbyIds[] = [$surveyId, $result['id']];
                }
            }

            if (!empty($hobbyIds)) {
                $this->db->insertMany('survey_hobbies', ['survey_id', 'hobby_id'], $hobbyIds);
            }

            $this->db->commit();
            return $surveyId;

        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function getErrors() {
        return $this->errors;
    }
} 