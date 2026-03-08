CREATE TABLE IF NOT EXISTS end_class (
    id INT(11) NOT NULL AUTO_INCREMENT,
    class_id INT(11) NOT NULL,
    user_id INT(11) DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP 
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uk_class (class_id),
    INDEX idx_class_id (class_id),
    INDEX idx_user_id (user_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS end_class_students (
    id INT(11) NOT NULL AUTO_INCREMENT,
    end_class_id INT(11) NOT NULL,
    student_id INT(11) NOT NULL,
    discounts INT(11) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uk_end_class_student (end_class_id, student_id),
    INDEX idx_end_class_id (end_class_id),
    INDEX idx_student_id (student_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
