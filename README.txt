Simple MVC (OOP) + AJAX (InfinityFree friendly)

1) Upload everything to your hosting (htdocs or subdomain htdocs).
2) Update app/config.php DB credentials.
3) Ensure your DB has tables like:
     classes(id, class_name, course, teacher_name, end_date, status)
     students(id, student_name, role, class_id)

   Or adjust queries in:
     app/Models/ClassModel.php
     app/Models/StudentModel.php

URLs:
  /dashboard
  /certificate

AJAX endpoints (via index.php):
  /api/classes?type=normal&course=
  /api/students?class_id=1
