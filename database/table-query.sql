-- ================================
-- USERS
-- ================================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  role ENUM('admin','instructor') NOT NULL DEFAULT 'instructor'
) ENGINE=InnoDB;


-- ================================
-- CLASSES
-- ================================
CREATE TABLE classes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course VARCHAR(80) NOT NULL,
  category VARCHAR(80) NOT NULL,
  time VARCHAR(60) NOT NULL,
  user_id INT NOT NULL,

  CONSTRAINT fk_classes_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ================================
-- STUDENTS
-- ================================
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  user_id INT NOT NULL,
  class_id INT NOT NULL,

  CONSTRAINT fk_students_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,

  CONSTRAINT fk_students_class
    FOREIGN KEY (class_id) REFERENCES classes(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ================================
-- END CLASS (FINISHED CLASS)
-- ================================
CREATE TABLE end_class (
  id INT AUTO_INCREMENT PRIMARY KEY,
  class_id INT NOT NULL,
  user_id INT NOT NULL,

  CONSTRAINT fk_end_class_class
    FOREIGN KEY (class_id) REFERENCES classes(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT fk_end_class_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,

  UNIQUE (class_id)
) ENGINE=InnoDB;


-- ================================
-- END CLASS STUDENTS
-- ================================
CREATE TABLE end_class_students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  end_class_id INT NOT NULL,
  student_id INT NOT NULL,

  CONSTRAINT fk_ecs_end_class
    FOREIGN KEY (end_class_id) REFERENCES end_class(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT fk_ecs_student
    FOREIGN KEY (student_id) REFERENCES students(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  UNIQUE (end_class_id, student_id)
) ENGINE=InnoDB;
