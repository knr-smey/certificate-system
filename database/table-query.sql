CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    password VARCHAR(255) NULL,
    role ENUM('admin','instructor') NOT NULL DEFAULT 'instructor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ================================
-- TEACHERS TABLE
-- ================================
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    phone VARCHAR(20) NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ================================
-- CLASSES TABLE
-- ================================
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(80) NOT NULL,
    category VARCHAR(80) NOT NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'normal',
    time VARCHAR(60) NOT NULL,
    teacher_id INT NULL,
    user_id INT NULL,
    status ENUM('active','completed','cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_classes_teacher
        FOREIGN KEY (teacher_id) REFERENCES teachers(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_classes_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
        
    INDEX idx_category (category),
    INDEX idx_type (type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ================================
-- STUDENTS TABLE
-- ================================
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(100) NULL,
    user_id INT NULL,
    class_id INT NOT NULL,
    enrollment_date DATE NULL,
    status ENUM('active','completed','dropped') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_students_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_students_class
        FOREIGN KEY (class_id) REFERENCES classes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    INDEX idx_class (class_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ================================
-- END CLASS (FINISHED CLASS) TABLE
-- ================================
CREATE TABLE IF NOT EXISTS end_class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    user_id INT NULL,
    end_date DATE NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_end_class_class
        FOREIGN KEY (class_id) REFERENCES classes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_end_class_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
        
    UNIQUE KEY uk_class (class_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ================================
-- END CLASS STUDENTS TABLE
-- ================================
CREATE TABLE IF NOT EXISTS end_class_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    end_class_id INT NOT NULL,
    student_id INT NOT NULL,
    grade VARCHAR(10) NULL,
    remarks TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_ecs_end_class
        FOREIGN KEY (end_class_id) REFERENCES end_class(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_ecs_student
        FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    UNIQUE KEY uk_end_class_student (end_class_id, student_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;