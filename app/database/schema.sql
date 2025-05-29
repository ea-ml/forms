-- Hobbies table
CREATE TABLE IF NOT EXISTS hobbies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default hobbies
INSERT INTO hobbies (name) VALUES 
    ('reading'),
    ('gaming'),
    ('sports'),
    ('cooking'),
    ('traveling');

-- Surveys table
CREATE TABLE IF NOT EXISTS surveys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(20) NOT NULL,
    lname VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    nationality_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    suggestions TEXT,
    created_at DATETIME NOT NULL,
    INDEX idx_email (email),
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_names (fname, lname),
    FOREIGN KEY (nationality_id) REFERENCES nationalities(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Survey_hobbies junction table for many-to-many relationship
CREATE TABLE IF NOT EXISTS survey_hobbies (
    survey_id INT NOT NULL,
    hobby_id INT NOT NULL,
    PRIMARY KEY (survey_id, hobby_id),
    FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE,
    FOREIGN KEY (hobby_id) REFERENCES hobbies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nationalities table
CREATE TABLE IF NOT EXISTS nationalities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default nationalities
INSERT INTO nationalities (name) VALUES 
    ('Filipino'),
    ('Japanese'),
    ('American'),
    ('British'),
    ('Australian'),
    ('Others'); 