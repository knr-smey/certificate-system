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
$router->get('/certificate-sys/certificate', [CertificateController::class, 'index']);
$router->get('/teacher', [TeacherController::class, 'index']);
$router->get('/form', [CertificateClassFreeController::class, 'index']);
$router->post('/form/submit', [CertificateClassFreeController::class, 'submit']);
$router->post('/certificate-sys/form/submit', [CertificateClassFreeController::class, 'submit']);
$router->get('/certificate-sys/form/fix-codes', [CertificateClassFreeController::class, 'fixCertificateCodes']);
$router->get('/form/fix-codes', [CertificateClassFreeController::class, 'fixCertificateCodes']);

// API Routes
$router->get('/api/classes', [CertificateController::class, 'getClasses']);
$router->get('/api/students', [CertificateController::class, 'getStudents']);
$router->get('/api/certificate-date', [CertificateController::class, 'getCertificateDate']);
// Course API
$router->post('/certificate-sys/api/course/save', [CourseApiController::class, 'save']);
$router->get('/certificate-sys/api/course/list', [CourseApiController::class, 'list']);
$router->post('/api/course/save', [CourseApiController::class, 'save']);
$router->get('/api/course/list', [CourseApiController::class, 'list']);
$router->post('/api/course/savenormal', [CourseApiController::class, 'savenormal']);
$router->get('/api/course/listnormal', [CourseApiController::class, 'listcousrnormal']);
$router->post('/api/course/delete', [CourseApiController::class, 'delete']);
// existing routes
// index.php
$router->get('/certificate/students', [CertificateController::class, 'students']);

// Dispatch
$router->dispatch();


