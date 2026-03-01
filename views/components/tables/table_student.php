<div class="container-fluid py-4 px-4" id="print_area">

    <!-- Back + Print Buttons (hidden when printing) -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="javascript:history.back()" class="btn-back">
            <i class="bi bi-arrow-left-circle-fill me-2"></i>ត្រឡប់ក្រោយ
        </a>
        <div class="page-badge text-white">
            <i class="bi bi-award-fill me-2"></i>បញ្ជីសិស្សសញ្ញាបត្រ
        </div>
    </div>

    <!-- Class Info Card (hidden when printing) -->
    <div class="info-card mb-4 no-print">
        <div class="info-card-header">
            <div class="header-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="header-title">ព័ត៌មានថ្នាក់រៀន</div>
                <div class="header-sub">Class Information</div>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="bi bi-book-fill me-1"></i>មុខវិជ្ជា</div>
                <div class="info-value text-accent" id="info_course">-</div>
            </div>
            <div class="info-divider"></div>
            <div class="info-item">
                <div class="info-label"><i class="bi bi-person-badge-fill me-1"></i>គ្រូបង្រៀន</div>
                <div class="info-value" id="info_teacher">-</div>
            </div>
            <div class="info-divider"></div>
            <div class="info-item">
                <div class="info-label"><i class="bi bi-clock-fill me-1"></i>ម៉ោងរៀន</div>
                <div class="info-value" id="info_time">-</div>
            </div>
        </div>
    </div>

    <!-- Student Table (hidden when printing) -->
    <div class="table-card no-print">
        <div class="table-card-header">
            <div class="d-flex align-items-center gap-3">
                <div class="table-icon"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="table-title">បញ្ជីឈ្មោះសិស្ស</div>
                    <div class="table-sub">Student List</div>
                </div>
            </div>
            <span class="count-badge" id="student_count">
                <div class="spinner-border spinner-border-sm" role="status"></div>
            </span>
        </div>

        <div class="table-responsive">
            <table class="student-table">
                <thead>
                    <tr>
                        <th class="col-no">ល.រ</th>
                        <th class="col-name">ឈ្មោះសិស្ស</th>
                        <th class="col-gender">ភេទ</th>
                        <th class="col-tel">លេខទូរស័ព្ទ</th>
                        <th class="col-score">ពិន្ទុ</th>
                        <th class="col-course">មុខវិជ្ជា</th>
                        <th class="col-action no-print">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody id="student_list">
                    <tr>
                        <td colspan="7" class="loading-cell">
                            <div class="loading-wrap">
                                <div class="spinner-border text-primary" role="status"></div>
                                <span>កំពុងផ្ទុក...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
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
                            <button class="cert-btn-regen" onclick="regenId()" title="Generate new ID" type="button">
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
                                        <div class="cert-school-kh">មជ្ឈមណ្ឌលវិស្វកម្មបច្ចេកវិទ្យា និង<span class=" text-black">អេឡិចត្រូនិក</span></div>
                                        <div class="cert-school-en"><span class=" text-black">Engineering</span> of Technology and Electronic Center</div>
                                        <div class="cert-title">Certificate of Completion</div>
                                        <div class="cert-certify">This is to certify that</div>
                                        <h1 class="cert-student-name" id="cert_student_name">—</h1>
                                        <div class="cert-desc">
                                            has successfully completed all requirements for completion<br>
                                            of the Computer Training Courses in
                                        </div>
                                        <h4 class="cert-course" id="cert_course">—</h4>
                                        <div class="cert-granted">Granted: <span id="cert_time">—</span></div>
                                        <div class="cert-footer">
                                            <div class="cert-id">ID : <span id="cert_id_val">—</span></div>
                                            <div class="cert-signature">
                                                <div class="cert-sig-line"></div>
                                                <div class="cert-sig-name text-center" id="cert_sign_teacher">Mr. Heng Pheakna</div>
                                                <div class="cert-sig-role text-center">Director</div>
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
                <button type="button" class="btn-cert-save" onclick="saveCourse()">
                    <i class="bi bi-bookmark-fill me-2"></i>រក្សាទុក Course
                </button>
                <button type="button" class="btn-cert-print text-white" onclick="printCertificate()">
                    <i class="bi bi-printer-fill me-2"></i>បោះពុម្ព
                </button>
            </div>

        </div>
    </div>
</div>


<style>
</style>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
let currentClass = { course: '-', teacher: '-', time: '-' };

$(document).ready(function () {
    const params  = new URLSearchParams(window.location.search);
    const classId = parseInt(params.get('class_id')) || 0;

    currentClass.course  = params.get('course')  || '-';
    currentClass.teacher = params.get('teacher') || '-';
    currentClass.time    = params.get('time')    || '-';

    $('#info_course').text(currentClass.course);
    $('#info_teacher').text(currentClass.teacher);
    $('#info_time').text(currentClass.time);

    if (classId > 0) {
        loadStudents(classId);
    } else {
        showError('មិនមាន class_id');
    }
});

function loadStudents(classId) {
    $.ajax({
        url: "<?= base_url('api/students') ?>",
        method: "GET",
        data: { class_id: classId },
        dataType: "json",
        success: function (result) {
            const tbody = $('#student_list');

            if (!result.data || result.data.length === 0) {
                tbody.html(`
                    <tr><td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-primary opacity-25"></i>
                        មិនមានសិស្ស
                    </td></tr>
                `);
                $('#student_count').text('0 នាក់');
                return;
            }

            $('#student_count').text(result.data.length + ' នាក់');

            const rows = result.data.map((s, i) => {
                const gender   = s.gender || 'Male';
                const gClass   = gender === 'Female' ? 'gender-f' : 'gender-m';
                const score    = parseInt(s.score) || 0;
                const sCls     = score >= 70 ? 'score-high' : score >= 50 ? 'score-mid' : 'score-low';
                const course   = s.course || currentClass.course;

                return `
                <tr>
                    <td class="text-center"><span class="row-no text-white">${s.id}</span></td>
                    <td>
                        <div class="student-name">
                            <div class="student-avatar"><i class="bi bi-person-fill"></i></div>
                            <span class="student-name-text">${s.name}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="gender-badge ${gClass}">${gender}</span>
                    </td>
                    <td>${s.tel || '-'}</td>
                    <td class="text-center">
                        <span class="score-pill ${sCls}">${score}</span>
                    </td>
                    <td>${course}</td>
                    <td class="text-center no-print">
                        <button class="btn-print-cert text-white"
                            onclick="openCertificate('${escapeHtml(s.name)}', '${escapeHtml(course)}', '${escapeHtml(currentClass.teacher)}', '${escapeHtml(currentClass.time)}', ${score})">
                            <i class="bi bi-printer-fill"></i> Print
                        </button>
                    </td>
                </tr>`;
            }).join('');

            tbody.html(rows);
        },
        error: function (xhr) {
            let msg = 'Server Error';
            try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {}
            showError(msg);
            $('#student_count').text('Error');
        }
    });
}

function openCertificate(name, course, teacher, time, score) {
    
    $('#edit_student_name').val(name);
    $('#edit_course').val(course);
   
    const today = new Date();
    const months = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];
    const granted = months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear();
    $('#edit_granted').val(granted);
   
    $('#edit_id').val(generateId()); // ← already calls your new generateId()

    const saved = getSavedCourse(course);
    if (saved) {
        $('#edit_course').val(saved);
    }

    updatePreview();
    renderSavedCourses();
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
    const year = new Date().getFullYear();
    const random4 = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
    return year + random4 + 'ETEC';
}


function regenId() {
    $('#edit_id').val(generateId());
    updatePreview();
}

// ── localStorage helpers ──────────────────────
const LS_KEY = 'cert_saved_courses';

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
    const original = currentClass.course;
    const custom   = $('#edit_course').val().trim();
    if (!custom) return;

    let list = getSavedCourses();
    // Update if exists, otherwise add
    const idx = list.findIndex(c => c.original === original);
    if (idx >= 0) {
        list[idx].custom = custom;
    } else {
        list.push({ original, custom });
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

function printCertificate() {
    window.print();
}

function showError(msg) {
    $('#student_list').html(`
        <tr><td colspan="7" class="text-center py-4 text-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>${msg}
        </td></tr>
    `);
}

function escapeHtml(str) {
    return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
</script>