<?php
// Get certificates from controller
$certificates = $certificates ?? [];

// Get the default certificate date (15th of the month) using helper function
$defaultCertDate = printCertificateDate('F j, Y');
?>

<div class="table-card mt-4">
    <div class="table-card-header">
        <div class="d-flex align-items-center gap-3">
            <div class="table-icon"><i class="bi bi-card-list"></i></div>
            <div>
                <div class="table-title">បញ្ជីស្នើរសុំសញ្ញាប័ត្រ</div>
                <div class="table-sub">Certificate Request List</div>
            </div>
        </div>
        <span class="count-badge">
            <?php echo $totalCount ?? count($certificates); ?> នាក់
        </span>
    </div>

    <div class="table-responsive">
        <table class="student-table">
            <thead>
                <tr>
                    <th class="col-no">ល.រ</th>
                    <th class="col-name">ឈ្មោះសិស្ស</th>
                    <th class="col-course">វគ្គសិក្សា</th>
                    <th class="col-date">ថ្ងៃបញ្ចប់</th>
                    <th class="col-action">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($certificates)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                            មិនមានទន្និន័យ
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($certificates as $index => $cert): ?>
                        <tr>
                            <td class="text-center">
                                <span class="row-no"><?php echo (($currentPage ?? 1) - 1) * 5 + $index + 1; ?></span>
                            </td>
                            <td>
                                <div class="student-name">
                                    
                                    <span class="student-name-text"><?php echo htmlspecialchars($cert['student_name'] ?? ''); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="course-badge"><?php echo htmlspecialchars($cert['course'] ?? ''); ?></span>
                            </td>
                            <td>
                                <span class="date-badge">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?php echo htmlspecialchars($cert['end_date'] ?? ''); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn-print-cert text-white" 
                                    onclick="openCertificateFree('<?php echo htmlspecialchars($cert['student_name'] ?? ''); ?>', '<?php echo htmlspecialchars($cert['course'] ?? ''); ?>', '<?php echo htmlspecialchars($cert['end_date'] ?? ''); ?>')">
                                    <i class="bi bi-printer-fill"></i> បោះពុម្ភ
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php $currentType = $_GET['type'] ?? ''; ?>
    <div class="pagination-wrapper">
        <nav aria-label="Table pagination">
            <ul class="pagination justify-content-center mb-0">
                <?php $currentPage = $currentPage ?? 1; ?>
                
                <!-- Previous Page Link -->
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?type=<?php echo $currentType; ?>&page=<?php echo $currentPage - 1; ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $currentPage): ?>
                        <li class="page-item active">
                            <span class="page-link"><?php echo $i; ?></span>
                        </li>
                    <?php elseif ($i <= 3 || $i > $totalPages - 2 || abs($i - $currentPage) <= 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?type=<?php echo $currentType; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php elseif ($i == 4 && $currentPage > 4): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php elseif ($i == $totalPages - 3 && $currentPage < $totalPages - 3): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>

                <!-- Next Page Link -->
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?type=<?php echo $currentType; ?>&page=<?php echo $currentPage + 1; ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="pagination-info">
            ទំព័រ <?php echo $currentPage; ?> នៃ <?php echo $totalPages; ?> | សរុប <?php echo $totalCount ?? 0; ?> កំណត់ត្រា
        </div>
    </div>
    <?php endif; ?>
</div>



