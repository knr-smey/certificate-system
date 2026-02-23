<?php
// Get certificates from controller
$certificates = $certificates ?? [];
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
                                    onclick="openCertificateFree('<?php echo htmlspecialchars($cert['student_name'] ?? ''); ?>', '<?php echo htmlspecialchars($cert['course'] ?? ''); ?>')">
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

<!-- ==================== PRINT CERTIFICATE MODAL ==================== -->
<div class="modal fade" id="certModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content cert-modal-content">

            <!-- Header (hidden when printing) -->
            <div class="modal-header cert-modal-header no-print">
                <h5 class="modal-title text-white">
                    <i class="bi bi-printer-fill me-2 "></i>បោះពុម្ពសញ្ញាបត្រ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body: two panels (left edit panel is hidden when printing) -->
            <div class="modal-body p-0 d-flex no-print" style="min-height:500px;">

                <!-- LEFT: Edit Form (hidden when printing) -->
                <div class="cert-edit-panel">
                    <div class="cert-edit-title">
                        <i class="bi bi-pencil-square me-2"></i>កែប្រែព័ត៌មាន
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">ឈ្មោះសិស្ស</label>
                        <input type="text" id="edit_student_name" class="cert-field-input" placeholder="Student name...">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">មុខវិជ្ជា / Course</label>
                        <input type="text" id="edit_course" class="cert-field-input" placeholder="Course name...">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">ថ្ងៃខែឆ្នាំ / Granted Date</label>
                        <input type="text" id="edit_granted" class="cert-field-input" placeholder="e.g. February 17, 2026">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">លេខ ID</label>
                        <div class="d-flex gap-2">
                            <input type="text" id="edit_id" class="cert-field-input" placeholder="Auto-generated">
                            <button class="cert-btn-regen" onclick="regenId()" title="Generate new ID">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Saved courses from localStorage -->
                    <div class="cert-saved-section" id="saved_courses_wrap" style="display:none">
                        <div class="cert-saved-title">
                            <i class="bi bi-bookmark-fill me-1"></i>Course រក្សាទុក
                        </div>
                        <div id="saved_courses_list"></div>
                    </div>
                </div>

                <!-- RIGHT: Certificate Preview (this is what prints) -->
                <div class="cert-preview-panel" id="printable-certificate">
                    <div class="cert-preview-label">PREVIEW</div>
                    <div id="certificate_content">
                        <div class="certificate-wrap">
                            <div class="certificate">
                                <div class="cert-outer-border">
                                    <div class="cert-inner-border">
                                        <div class="cert-kingdom">
                                            <div>KINGDOM OF CAMBODIA</div>
                                            <div>NATION&nbsp; RELIGION &nbsp;KING</div>
                                        </div>
                                        <div class="cert-logo-area">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCRerloxG_go8MpvD_FYvHwpSWb7580gwmBw&s"
                                                 alt="Logo" class="cert-logo-img"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="cert-logo-fallback">
                                                <i class="bi bi-award-fill"></i>
                                            </div>
                                        </div>
                                        <div class="cert-school-kh">បច្ចេកវិទ្យាព័ត៌មាននិងអេឡិចត្រូនិច វិទ្យាល័យបច្ចេក</div>
                                        <div class="cert-school-en">Engineering of Technology and Electronic Center</div>
                                        <div class="cert-title">Certificate of Completion</div>
                                        <div class="cert-certify">This is to certify that</div>
                                        <div class="cert-student-name" id="cert_student_name">—</div>
                                        <div class="cert-desc">
                                            has successfully completed all requirements for completion<br>
                                            of the Computer Training Courses in
                                        </div>
                                        <div class="cert-course" id="cert_course">—</div>
                                        <div class="cert-granted">Granted: <span id="cert_time">—</span></div>
                                        <div class="cert-footer">
                                            <div class="cert-id">ID : <span id="cert_id_val">—</span></div>
                                            <div class="cert-signature">
                                                <div class="cert-sig-line"></div>
                                                <div class="cert-sig-name" id="cert_sign_teacher">Mr. Heng Pheakna</div>
                                                <div class="cert-sig-role">Director</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer buttons (hidden when printing) -->
            <div class="modal-footer cert-modal-footer no-print">
                <button type="button" class="btn-cert-close" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>បិទ
                </button>
              
                <button type="button" class="btn-cert-print text-white" onclick="printCertificate()">
                    <i class="bi bi-printer-fill me-2"></i> បោះពុម្ព 
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function openCertificateFree(name, course) {
    $('#edit_student_name').val(name);
    $('#edit_course').val(course);
   
    const today = new Date();
    const months = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];
    const granted = months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear();
    $('#edit_granted').val(granted);
   
    $('#edit_id').val(generateId());
    
    updatePreview();
    
    // Open modal
    new bootstrap.Modal(document.getElementById('certModal')).show();
}

// Live update preview as user types
$(document).on('input', '#edit_student_name, #edit_course, #edit_granted, #edit_id', function() {
    updatePreview();
});

function updatePreview() {
    const name    = $('#edit_student_name').val() || '—';
    const course  = $('#edit_course').val()        || '—';
    const granted = $('#edit_granted').val()       || '—';
    const id      = $('#edit_id').val()            || '—';

    $('#cert_student_name').text(name);
    $('#cert_course').text(course);
    $('#cert_time').text(granted);
    $('#cert_id_val').text(id);
    $('#cert_sign_teacher').text('Mr. Heng Pheakna');
}

function generateId() {
    const num = String(Math.floor(Math.random() * 9000000000) + 1000000000).substring(0, 10);
    return num + ' ETEC';
}

function regenId() {
    $('#edit_id').val(generateId());
    updatePreview();
}

function printCertificate() {
    window.print();
}

// ── localStorage helpers for saved courses ──────────────────────
const LS_KEY = 'cert_saved_courses_free';

function getSavedCourses() {
    try { return JSON.parse(localStorage.getItem(LS_KEY)) || []; }
    catch(e) { return []; }
}

function getSavedCourse(courseName) {
    const list = getSavedCourses();
    const match = list.find(c => c.original === courseName);
    return match ? match.custom : null;
}

function saveCourse() {
    const custom   = $('#edit_course').val().trim();
    if (!custom) return;

    let list = getSavedCourses();
    const idx = list.findIndex(c => c.original === custom);
    if (idx >= 0) {
        list[idx].custom = custom;
    } else {
        list.push({ original: custom, custom: custom });
    }
    localStorage.setItem(LS_KEY, JSON.stringify(list));
    renderSavedCourses();

    // Flash saved hint
    const btn = $('.btn-cert-save');
    btn.html('<i class="bi bi-check-circle-fill me-2"></i>រក្សាទុករួច!');
    setTimeout(() => btn.html('<i class="bi bi-bookmark-fill me-2"></i>រក្សាទុក Course'), 1800);
}

function renderSavedCourses() {
    const list = getSavedCourses();
    if (list.length === 0) {
        $('#saved_courses_wrap').hide();
        return;
    }
    $('#saved_courses_wrap').show();
    const html = list.map((c, i) => `
        <div class="cert-saved-item" onclick="applySavedCourse('${escapeHtml(c.custom)}')">
            <span class="cert-saved-item-name" title="${escapeHtml(c.custom)}">${escapeHtml(c.custom)}</span>
            <button class="cert-saved-item-del" onclick="event.stopPropagation();deleteSavedCourse(${i})" title="Delete">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    `).join('');
    $('#saved_courses_list').html(html);
}

function applySavedCourse(custom) {
    $('#edit_course').val(custom);
    updatePreview();
}

function deleteSavedCourse(idx) {
    let list = getSavedCourses();
    list.splice(idx, 1);
    localStorage.setItem(LS_KEY, JSON.stringify(list));
    renderSavedCourses();
}

function escapeHtml(str) {
    return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
</script>
