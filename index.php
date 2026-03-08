<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

use App\Controllers\CertificateClassFreeController;
use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\CertificateController;
use App\Controllers\TeacherController;

use App\Controllers\CourseApiController;

$router = new Router();

// Pages
$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/certificate', [CertificateController::class, 'index']);
$router->get('/teacher', [TeacherController::class, 'index']);
$router->get('/form', [CertificateClassFreeController::class, 'index']);
$router->post('/form/submit', [CertificateClassFreeController::class, 'submit']);

// API Routes
$router->get('/api/classes', [CertificateController::class, 'getClasses']);
$router->get('/api/students', [CertificateController::class, 'getStudents']);
$router->get('/api/certificate-date', [CertificateController::class, 'getCertificateDate']);
// Course API
$router->post('/api/course/save', [CourseApiController::class, 'save']);
$router->get('/api/course/list', [CourseApiController::class, 'list']);
// existing routes
// index.php
$router->get('/certificate/students', [CertificateController::class, 'students']);

// Dispatch
$router->dispatch();


