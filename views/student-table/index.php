<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #2C2B7C;
            color: white;
            padding-top: 20px;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1C1B4E;
            color: white;
        }

        /* Main content */
        .main {
            margin-left: 250px;
            padding: 30px;
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
            font-size: 16px;
        }

        /* Print style */
        @media print {

            .sidebar,
            .btn-print {
                display: none !important;
            }

            .main {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="#" class="active">Student-table</a>
    </div>

    <!-- Main Content -->
    <div class="main">

        <!-- Top row: title + print button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Nat Sokphary</h3>
            <button onclick="window.print()" class="btn btn-primary btn-print">
                🖨️ Print
            </button>
        </div>

        <!-- Table Card -->
        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Tel</th>
                            <th>Score</th>
                            <th>Course</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jonh</td>
                            <td>Male</td>
                            <td>123456789</td>
                            <td>100</td>
                            <td>Web Design + React.js</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <!-- <nav class="mt-3">
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link">Next</a>
                        </li>
                    </ul>
                </nav> -->

            </div>
        </div>

    </div>

</body>

</html>