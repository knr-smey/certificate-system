-- =======================================
-- TEST DATA (REAL NAMES + TIME RANGE)
-- =======================================

-- USERS (INSTRUCTORS)
INSERT INTO users (name, role) VALUES
('Mr. John', 'instructor'),
('Ms. Anna', 'instructor'),
('Mr. David', 'instructor');


-- CLASSES
INSERT INTO classes (course, category, time, user_id) VALUES
('React',   'Web Frontend', '09:00 - 10:30', 1),
('Vue',     'Web Frontend', '10:30 - 12:00', 1),
('NodeJS',  'Web Backend',  '13:00 - 14:30', 2),
('Flutter', 'Mobile App',   '14:30 - 16:00', 2),
('Laravel', 'Web Backend',  '16:00 - 17:30', 3);


-- STUDENTS (REALISTIC NAMES)
INSERT INTO students (name, user_id, class_id) VALUES
-- React class (1)
('Dara',1,1),('Sok',1,1),('Vann',1,1),('Srey',1,1),('Bora',1,1),
('Rith',1,1),('Kanha',1,1),('Nita',1,1),('Chenda',1,1),('Pisey',1,1),

-- Vue class (2)
('Mony',1,2),('Sopheak',1,2),('Rina',1,2),('Tola',1,2),('Sarin',1,2),
('Visal',1,2),('Sokha',1,2),('Lina',1,2),('Dalin',1,2),('Vichea',1,2),

-- NodeJS class (3)
('Rathanak',2,3),('Makara',2,3),('Chivy',2,3),('Pheaktra',2,3),('Sokun',2,3),
('Phalla',2,3),('Chantha',2,3),('Rasy',2,3),('Kosal',2,3),('Kimleng',2,3),

-- Flutter class (4)
('Sophal',2,4),('Malis',2,4),('Sreypov',2,4),('Ravy',2,4),('Sovann',2,4),
('Dany',2,4),('Leakhena',2,4),('Theary',2,4),('Sokny',2,4),('Mesa',2,4),

-- Laravel class (5)
('Samnang',3,5),('Thyda',3,5),('Bunthong',3,5),('Channary',3,5),('Sokchea',3,5),
('Rorn',3,5),('Sreyneang',3,5),('Kunthea',3,5),('Raksmy',3,5),('Sopheary',3,5);


-- END CLASSES
INSERT INTO end_class (class_id, user_id) VALUES
(1,1),
(2,1),
(3,2),
(4,2),
(5,3);


-- LINK STUDENTS TO END CLASSES
INSERT INTO end_class_students (end_class_id, student_id) VALUES
-- React
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),

-- Vue
(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17),(2,18),(2,19),(2,20),

-- NodeJS
(3,21),(3,22),(3,23),(3,24),(3,25),(3,26),(3,27),(3,28),(3,29),(3,30),

-- Flutter
(4,31),(4,32),(4,33),(4,34),(4,35),(4,36),(4,37),(4,38),(4,39),(4,40),

-- Laravel
(5,41),(5,42),(5,43),(5,44),(5,45),(5,46),(5,47),(5,48),(5,49),(5,50);
