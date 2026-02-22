-- =======================================
-- CLEAR OLD DATA (OPTIONAL - BE CAREFUL!)
-- =======================================
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE certificate_class_free;
TRUNCATE TABLE end_class_students;
TRUNCATE TABLE end_class;
TRUNCATE TABLE students;
TRUNCATE TABLE classes;
TRUNCATE TABLE teachers;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;


-- =======================================
-- INSERT TEACHERS FIRST
-- =======================================
INSERT INTO teachers (teacher_name, email, phone, status) VALUES
('Mr. John', 'john@school.com', '012-111-111', 'active'),
('Ms. Anna', 'anna@school.com', '012-222-222', 'active'),
('Mr. David', 'david@school.com', '012-333-333', 'active'),
('Mr. Dara', 'dara@gmail.com', '012-345-678', 'active'),
('Ms. Lina', 'lina@gmail.com', '098-765-432', 'active');


-- =======================================
-- INSERT USERS (INSTRUCTORS)
-- =======================================
INSERT INTO users (name, email, role) VALUES
('Mr. John', 'john@school.com', 'instructor'),
('Ms. Anna', 'anna@school.com', 'instructor'),
('Mr. David', 'david@school.com', 'instructor'),
('Admin User', 'admin@school.com', 'admin');


-- =======================================
-- INSERT CLASSES (WITH BOTH teacher_id AND user_id)
-- =======================================
INSERT INTO classes (course, category, type, time, teacher_id, user_id, status) VALUES
('React',   'Web Frontend', 'normal', '09:00 - 10:30', 1, 1, 'active'),
('Vue',     'Web Frontend', 'normal', '10:30 - 12:00', 1, 1, 'active'),
('NodeJS',  'Web Backend',  'normal', '13:00 - 14:30', 2, 2, 'active'),
('Flutter', 'Mobile App',   'normal', '14:30 - 16:00', 2, 2, 'active'),
('Laravel', 'Web Backend',  'normal', '16:00 - 17:30', 3, 3, 'active'),
('Class Free', 'Certificate', 'free', 'N/A', NULL, NULL, 'active');


-- =======================================
-- INSERT STUDENTS
-- =======================================
INSERT INTO students (name, user_id, class_id, status) VALUES
-- React class (1)
('Dara', 1, 1, 'active'),
('Sok', 1, 1, 'active'),
('Vann', 1, 1, 'active'),
('Srey', 1, 1, 'active'),
('Bora', 1, 1, 'active'),
('Rith', 1, 1, 'active'),
('Kanha', 1, 1, 'active'),
('Nita', 1, 1, 'active'),
('Chenda', 1, 1, 'active'),
('Pisey', 1, 1, 'active'),

-- Vue class (2)
('Mony', 1, 2, 'active'),
('Sopheak', 1, 2, 'active'),
('Rina', 1, 2, 'active'),
('Tola', 1, 2, 'active'),
('Sarin', 1, 2, 'active'),
('Visal', 1, 2, 'active'),
('Sokha', 1, 2, 'active'),
('Lina', 1, 2, 'active'),
('Dalin', 1, 2, 'active'),
('Vichea', 1, 2, 'active'),

-- NodeJS class (3)
('Rathanak', 2, 3, 'active'),
('Makara', 2, 3, 'active'),
('Chivy', 2, 3, 'active'),
('Pheaktra', 2, 3, 'active'),
('Sokun', 2, 3, 'active'),
('Phalla', 2, 3, 'active'),
('Chantha', 2, 3, 'active'),
('Rasy', 2, 3, 'active'),
('Kosal', 2, 3, 'active'),
('Kimleng', 2, 3, 'active'),

-- Flutter class (4)
('Sophal', 2, 4, 'active'),
('Malis', 2, 4, 'active'),
('Sreypov', 2, 4, 'active'),
('Ravy', 2, 4, 'active'),
('Sovann', 2, 4, 'active'),
('Dany', 2, 4, 'active'),
('Leakhena', 2, 4, 'active'),
('Theary', 2, 4, 'active'),
('Sokny', 2, 4, 'active'),
('Mesa', 2, 4, 'active'),

-- Laravel class (5)
('Samnang', 3, 5, 'active'),
('Thyda', 3, 5, 'active'),
('Bunthong', 3, 5, 'active'),
('Channary', 3, 5, 'active'),
('Sokchea', 3, 5, 'active'),
('Rorn', 3, 5, 'active'),
('Sreyneang', 3, 5, 'active'),
('Kunthea', 3, 5, 'active'),
('Raksmy', 3, 5, 'active'),
('Sopheary', 3, 5, 'active');


-- =======================================
-- INSERT END CLASSES
-- =======================================
INSERT INTO end_class (class_id, user_id, end_date) VALUES
(1, 1, '2024-12-15'),
(2, 1, '2024-12-20'),
(3, 2, '2024-12-18'),
(4, 2, '2024-12-22'),
(5, 3, '2024-12-25');


-- =======================================
-- LINK STUDENTS TO END CLASSES
-- =======================================
INSERT INTO end_class_students (end_class_id, student_id, grade) VALUES
-- React (end_class_id = 1)
(1,1,'A'),(1,2,'B'),(1,3,'A'),(1,4,'B'),(1,5,'A'),
(1,6,'B'),(1,7,'A'),(1,8,'C'),(1,9,'B'),(1,10,'A'),

-- Vue (end_class_id = 2)
(2,11,'A'),(2,12,'B'),(2,13,'A'),(2,14,'B'),(2,15,'A'),
(2,16,'B'),(2,17,'A'),(2,18,'C'),(2,19,'B'),(2,20,'A'),

-- NodeJS (end_class_id = 3)
(3,21,'A'),(3,22,'B'),(3,23,'A'),(3,24,'B'),(3,25,'A'),
(3,26,'B'),(3,27,'A'),(3,28,'C'),(3,29,'B'),(3,30,'A'),

-- Flutter (end_class_id = 4)
(4,31,'A'),(4,32,'B'),(4,33,'A'),(4,34,'B'),(4,35,'A'),
(4,36,'B'),(4,37,'A'),(4,38,'C'),(4,39,'B'),(4,40,'A'),

-- Laravel (end_class_id = 5)
(5,41,'A'),(5,42,'B'),(5,43,'A'),(5,44,'B'),(5,45,'A'),
(5,46,'B'),(5,47,'A'),(5,48,'C'),(5,49,'B'),(5,50,'A');


-- =======================================
-- INSERT CERTIFICATE CLASS FREE
-- =======================================
INSERT INTO certificate_class_free (student_name, course, end_date, status) VALUES
('SOK SREYMOM', 'Graphic Design', '2024-12-15', 'approved'),
('CHEA VANNARY', 'Web Development', '2024-11-20', 'approved'),
('HENG SOKHA', 'English Communication', '2024-10-10', 'pending'),
('LIM SREYNA', 'Digital Marketing', '2024-09-05', 'approved'),
('TOK SOKHEANG', 'Photography', '2024-08-22', 'pending'),
('ORN SOPHARA', 'Video Editing', '2024-12-01', 'approved'),
('SUN SOVANN', 'UI/UX Design', '2024-11-15', 'approved'),
('TRY RATHA', 'Mobile App Development', '2024-10-30', 'pending');