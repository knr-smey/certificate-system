<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class DashboardController extends Controller
{
    // public function index(): void
    // {
    //     $this->view('dashboard/index', [
    //         'title' => 'Dashboard',
    //     ]);
    // }
   public function index(): void
    {
        header("Location: /certificate-sys/certificate?type=free");
        exit;
    }
}
