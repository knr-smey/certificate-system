<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TeacherModel;

final class TeacherController extends Controller
{
    public function index(): void
    {
        $model = new TeacherModel();
        $teachers = $model->getAllTeachers();

        $this->view('teacher/index', [
            'title' => 'Teacher',
            'teachers' => $teachers
        ]);
    }
}
