<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\CertificateController;
use App\Controllers\TeacherController;

$router = new Router();

// Pages
$router->get('/', [DashboardController::class, 'index']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/certificate', [CertificateController::class, 'index']);
$router->get('/teacher', [TeacherController::class, 'index']);

// API Routes
$router->get('/api/classes', [CertificateController::class, 'getClasses']);
$router->get('/api/students', [CertificateController::class, 'getStudents']);

// Dispatch
$router->dispatch();
