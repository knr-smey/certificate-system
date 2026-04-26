<input type="hidden" id="current_student_id" value="0">

<div class="container-fluid px-4" id="print_area">

    <!-- Back + Print All Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="javascript:history.back()" class="btn-back">
            <i class="bi bi-arrow-left-circle-fill me-2"></i>ត្រឡប់ក្រោយ
        </a>
        <div class="d-flex align-items-center gap-3">
            <!-- ✅ Print All Button -->
            <button class="btn btn-success fw-bold" onclick="printAllCertificates()">
                <i class="bi bi-printer-fill me-2"></i>បោះពុម្ពទាំងអស់
            </button>
            <div class="page-badge text-white">
                <i class="bi bi-award-fill me-2"></i>បញ្ជីសិស្សសញ្ញាបត្រ
            </div>
        </div>
    </div>

    <!-- Class Info Card -->
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

    <!-- Student Table -->
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

<!-- ==================== CERTIFICATE MODAL ==================== -->
<div class="modal fade" id="certModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content cert-modal-content">

            <!-- Header -->
            <div class="modal-header cert-modal-header no-print">
                <h5 class="modal-title text-white">
                    <i class="bi bi-printer-fill me-2"></i>បោះពុម្ពសញ្ញាបត្រ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-0 d-flex no-print" style="min-height:500px;">

                <!-- LEFT: Edit Form -->
                <div class="cert-edit-panel">
                    <div class="cert-edit-title">
                        <i class="bi bi-pencil-square me-2"></i>កែប្រែព័ត៌មាន
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">ឈ្មោះសិស្ស</label>
                        <input type="text" id="edit_student_name" class="cert-field-input"
                               placeholder="Student name...">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">មុខវិជ្ជា / Course</label>
                        <input type="text" id="edit_course" class="cert-field-input"
                               placeholder="Course name...">
                    </div>

                    <!-- Saved Courses Dropdown -->
                    <div class="cert-field-group" id="saved_courses_wrap" style="display:none;">
                        <label class="cert-field-label">
                            <i class="bi bi-bookmark-fill me-1 text-primary"></i>
                            Course រក្សាទុក
                            <span class="badge bg-primary ms-2" id="saved_count">0</span>
                        </label>
                        <div class="d-flex gap-2">
                            <select id="saved_courses_select"
                                    class="cert-field-input"
                                    onchange="applySavedCourseFromSelect(this.value)">
                                <option value="">-- ជ្រើសរើស Course --</option>
                            </select>
                            <button type="button"
                                    class="btn btn-danger"
                                    onclick="deleteSelectedCourse()"
                                    title="លុប Course ដែលជ្រើស">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">
                            ថ្ងៃខែឆ្នាំ / Granted Date
                        </label>
                        <input type="date" id="edit_granted" class="cert-field-input">
                    </div>

                    <!-- <div class="cert-field-group">
                        <label class="cert-field-label">លេខ ID</label>
                        <div class="d-flex gap-2">
                            <input type="text" id="edit_id" class="cert-field-input"
                                   placeholder="Auto-generated">
                            <button class="cert-btn-regen" onclick="regenId()"
                                    title="Generate new ID" type="button">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div> -->
                </div>

                <!-- RIGHT: Certificate Preview -->
                <div class="cert-preview-panel" id="printable-certificate">
                    <div class="cert-preview-label">PREVIEW</div>
                    <div id="certificate_content">
                        <div class="certificate-wrap">
                            <div class="certificate">
                                <div class="cert-outer-border">
                                    <div class="cert-inner-border">
                                        <div class="cert-kingdom">
                                            <div>KINGDOM OF CAMBODIA</div>
                                            <div>NATION&nbsp;RELIGION&nbsp;KING</div>
                                             <img src="<?= base_url('assets/Images/border.png') ?>" alt="">
                                        </div>
                                        <div class="cert-logo-area">
                                            <img src="<?= base_url('assets/Images/logo2.png') ?>"
                                                 alt="Logo" class="cert-logo-img"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="cert-logo-fallback">
                                                <i class="bi bi-award-fill"></i>
                                            </div>
                                        </div>
                                        <div class="cert-school-kh">មជ្ឈមណ្ឌលវិស្វកម្មបច្ចេកវិទ្យា និង<span class="text-black">អេឡិចត្រូនិក</span></div>
                                        <div class="cert-school-en"><span class="text-black">Engineering</span> of Technology and Electronic Center</div>
                                        <div class="cert-title">Certificate of Completion</div>
                                        <div class="cert-certify">This is to certify that</div>
                                        <h1 class="cert-student-name" id="cert_student_name">—</h1>
                                        <div class="cert-desc">
                                            has successfully completed all requirements for completion<br>
                                            of the I.T Training Courses in
                                        </div>
                                        <h4 class="cert-course" id="cert_course">—</h4>
                                        <div class="cert-granted"
                                            id="cert_granted"
                                            data-default="<?= printCertificateDate('F j,Y') ?>">
                                            Granted: <?= printCertificateDate('F j,Y') ?>
                                        </div>
                                        <div class="cert-footer">
                                            <?php $normalCertId = generateNormal(); ?>
                                            <div class="cert-id"><span class="id_text">ID:</span> <span id="certId"><?= htmlspecialchars($normalCertId) ?></span></div>
                                            <input type="hidden" id="cert_id_value" value="<?= htmlspecialchars($normalCertId, ENT_QUOTES, 'UTF-8') ?>">
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

            <!-- Footer -->
            <div class="modal-footer cert-modal-footer no-print">
                <button type="button" class="btn-cert-close" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>បិទ
                </button>
                <button type="button" class="btn-cert-save" onclick="saveCourse()">
                    <i class="bi bi-bookmark-fill me-2"></i>រក្សាទុក Course
                </button>
                <button type="button" class="btn-cert-print text-white" onclick="printCertificateStudent()">
                    <i class="bi bi-printer-fill me-2"></i>បោះពុម្ព
                </button>
            </div>

        </div>
    </div>
</div>

<style>
#saved_courses_select { cursor: pointer; }
#saved_courses_select option { padding: 8px; }
input[type="date"] {
  color: #555;
}
</style>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

let currentClass   = { course: '-', teacher: '-', time: '-' };
let currentClassId = 0;
let allStudents    = []; // ✅ រក្សាសិស្សទាំងអស់សម្រាប់ Print All
let remainingStudents = 0;

// ══════════════════════════════════════════
//   INIT
// ══════════════════════════════════════════
$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);
    currentClassId = parseInt(params.get('class_id')) || 0;

    currentClass.course  = params.get('course')  || '-';
    currentClass.teacher = params.get('teacher') || '-';
    currentClass.time    = params.get('time')    || '-';

    $('#info_course').text(currentClass.course);
    $('#info_teacher').text(currentClass.teacher);
    $('#info_time').text(currentClass.time);

    if (currentClassId > 0) {
        loadStudents(currentClassId);
    } else {
        showError('មិនមាន class_id');
    }
});

// ══════════════════════════════════════════
//   Load Students
// ══════════════════════════════════════════
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
                    </td></tr>`);
                $('#student_count').text('0 នាក់');
                return;
            }

            allStudents = result.data; // ✅ save សម្រាប់ Print All
            remainingStudents = result.data.filter(s => parseInt(s.is_printed, 10) !== 1).length;
            updateStudentCount();

            const rows = result.data.map((s) => {
                const gender = s.gender || 'Male';
                const gClass = gender === 'Female' ? 'gender-f' : 'gender-m';
                const course = s.course || currentClass.course;
                const isPrinted = parseInt(s.is_printed, 10) === 1;
                const printedClass = isPrinted ? 'student-printed' : '';
                const actionButtons = isPrinted
                    ? `
                        <div class="print-actions">
                            <button type="button" class="btn-print-done text-white" disabled>
                                <i class="bi bi-check-circle-fill"></i> Printed
                            </button>
                            <button type="button" class="btn-print-again text-white"
                                onclick="openCertificate(
                                    ${s.id},
                                    '${escapeHtml(s.name)}',
                                    '${escapeHtml(course)}',
                                    '${escapeHtml(currentClass.teacher)}',
                                    '${escapeHtml(currentClass.time)}')">
                                <i class="bi bi-printer-fill"></i> Re-print
                            </button>
                        </div>`
                    : `
                        <button class="btn-print-cert text-white"
                            onclick="openCertificate(
                                ${s.id},
                                '${escapeHtml(s.name)}',
                                '${escapeHtml(course)}',
                                '${escapeHtml(currentClass.teacher)}',
                                '${escapeHtml(currentClass.time)}')">
                            <i class="bi bi-printer-fill"></i> Print
                        </button>`;

                return `
                <tr data-student-id="${s.id}" class="${printedClass}">
                    <td class="text-center">
                        <span class="row-no text-white">${s.id}</span>
                    </td>
                    <td>
                        <div class="student-name">
                            <div class="student-avatar"><i class="bi bi-person-fill"></i></div>
                                <span class="student-name-text">${s.name.toUpperCase()}</span>
                            </div>
                    </td>
                    <td class="text-center">
                        <span class="gender-badge ${gClass}">${gender}</span>
                    </td>
                    <td>${s.tel || '-'}</td>
                    <td>${course}</td>
                    <td class="text-center no-print">
                        ${actionButtons}
                    </td>
                </tr>`;
            }).join('');

            tbody.html(rows);
            markPrintedRowsFromServer(classId);
        },
        error: function (xhr) {
            let msg = 'Server Error';
            try { msg = JSON.parse(xhr.responseText).message || msg; } catch(e) {}
            showError(msg);
            $('#student_count').text('Error');
        }
    });
}

// ══════════════════════════════════════════
//   Open Certificate Modal (Single)
// ══════════════════════════════════════════
function openCertificate(studentId, name, course, teacher, time) {
    $('#current_student_id').val(studentId); // ✅ save student_id
    $('#edit_student_name').val(name);
    $('#edit_course').val(course);

    const today   = new Date();
    const months  = ['January','February','March','April','May','June',
                     'July','August','September','October','November','December'];
    const granted = months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear();
    // $('#edit_granted').val(granted);
    $('#edit_granted').val('');
    $('#edit_id').val(generateId());

    updatePreview();
    renderSavedCourses();
    new bootstrap.Modal(document.getElementById('certModal')).show();
}

// ── Live preview ──
$(document).on('input', '#edit_student_name, #edit_course, #edit_granted, #edit_id', function () {
    updatePreview();
    if ($(this).attr('id') === 'edit_course') renderSavedCourses();
});
function formatDate(dateStr) {
    if (!dateStr) return '';

    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
function updatePreview() {
    $('#cert_student_name').text($('#edit_student_name').val() || '—');
    $('#cert_course').text($('#edit_course').val() || '—');

    const raw = $('#edit_granted').val();
    const defaultDate = $('#cert_granted').data('default');

    if (raw) {
        $('#cert_granted').text('Granted: ' + formatDate(raw));
    } else {
        $('#cert_granted').text('Granted: ' + defaultDate);
    }

    $('#cert_sign_teacher').text('Mr. Heng Pheakna');
}

// ══════════════════════════════════════════
//   ID Generator
// ══════════════════════════════════════════
function generateId() {
    const year    = new Date().getFullYear();
    const random4 = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
    return year + random4 + 'ETEC';
}
function regenId() {
    // $('#edit_id').val(generateId());
    updatePreview();
}

// ══════════════════════════════════════════
//   Course Management (Database)
// ══════════════════════════════════════════
function saveCourse() {
    const custom = $('#edit_course').val().trim();
    if (!custom) {
        Swal.fire({ icon: 'warning', title: 'សូមបញ្ចូល Course សិន!', timer: 1500, showConfirmButton: false });
        return;
    }
    $.ajax({
        url: "<?= base_url('api/course/savenormal') ?>",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ course_name: custom }),
        success: function (result) {
            if (result.success) {
                renderSavedCourses();
                Swal.fire({ icon: 'success', title: 'រក្សាទុករួច!', timer: 1200, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'info', title: result.message || 'មានរួចហើយ!', timer: 1500, showConfirmButton: false });
            }
        },
        error: function () { Swal.fire({ icon: 'error', title: 'Server Error' }); }
    });
}

function renderSavedCourses() {
    $.ajax({
        url: "<?= base_url('api/course/listnormal') ?>",
        method: "GET",
        dataType: "json",
        success: function (result) {
            const courses = result.courses || [];
            $('#saved_count').text(courses.length);
            if (courses.length === 0) { $('#saved_courses_wrap').hide(); return; }
            $('#saved_courses_wrap').show();

            const currentVal = $('#edit_course').val().trim().toLowerCase();
            let options = `<option value="">-- ជ្រើសរើស Course --</option>`;
            options += courses.map(c => {
                const name = typeof c === 'object' ? c.course_name : c;
                const sel  = name.toLowerCase() === currentVal ? 'selected' : '';
                return `<option value="${escapeHtml(name)}" ${sel}>${escapeHtml(name)}</option>`;
            }).join('');
            $('#saved_courses_select').html(options);
        },
        error: function () { console.error('Cannot load courses'); }
    });
}

function applySavedCourseFromSelect(value) {
    if (!value) return;
    $('#edit_course').val(value);
    updatePreview();
}

function deleteSelectedCourse() {
    const val = $('#saved_courses_select').val();
    if (!val) {
        Swal.fire({ icon: 'warning', title: 'សូមជ្រើសរើស Course មុនសិន!', timer: 1500, showConfirmButton: false });
        return;
    }
    $.ajax({
        url: "<?= base_url('api/course/delete') ?>",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ course_name: val }),
        success: function (res) {
            if (res.success) {
                if ($('#edit_course').val().trim().toLowerCase() === val.toLowerCase()) {
                    $('#edit_course').val('');
                    updatePreview();
                }
                renderSavedCourses();
                Swal.fire({ icon: 'success', title: 'លុបរួច!', timer: 1200, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'Delete failed: ' + (res.message || '') });
            }
        },
        error: function () { Swal.fire({ icon: 'error', title: 'Server Error' }); }
    });
}

// ══════════════════════════════════════════
//   ✅ Helper: Save Certificate to DB
// ══════════════════════════════════════════
function saveCertificateToDB(studentId, studentName, course, granted, certId) {
    return $.ajax({
        url: "<?= base_url('api/certificate/savenormal') ?>",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            student_id:     studentId,
            class_id:       currentClassId,
            student_name:   studentName,
            course:         course,
            granted_date:   granted,
            certificate_id: certId
        })
    });
}

// ══════════════════════════════════════════
//   ✅ PRINT SINGLE — SweetAlert confirm
// ══════════════════════════════════════════
function printCertificateStudent() {
    const studentId   = parseInt($('#current_student_id').val()) || 0;
    const studentName = $('#edit_student_name').val().trim();
    const course      = $('#edit_course').val().trim();
    const granted     = $('#edit_granted').val().trim();
    const certId      = ($('#cert_id_value').val() || $('#certId').text() || '').trim();

    // 1. Print
    window.print();

    // 2. Ask after print dialog closes
    setTimeout(async function () {
        const result = await Swal.fire({
            icon: 'question',
            title: 'បោះពុម្ពជោគជ័យទេ?',
            html: `<b>${studentName}</b><br><small class="text-muted">${course}</small>`,
            showCancelButton:   true,
            confirmButtonText:  '<i class="bi bi-check-lg me-1"></i> បាទ/ចាស ជោគជ័យ',
            cancelButtonText:   '<i class="bi bi-x-lg me-1"></i> ទេ មានបញ្ហា',
            confirmButtonColor: '#198754',
            cancelButtonColor:  '#dc3545',
        });

        if (result.isConfirmed) {
            // 3. Insert to DB
            try {
                const res = await saveCertificateToDB(studentId, studentName, course, granted, certId);
                if (res.ok) {
                    markStudentPrinted((res.data && res.data.student_id) ? res.data.student_id : studentId);
                    // console.log('Certificate saved with ID:', res);  
                    Swal.fire({ icon: 'success', title: 'រក្សាទុករួច!', timer: 1500, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'warning', title: res.error || 'មានបញ្ហា!' });
                }
            } catch(e) {
               console.error(e);
            }
        }
    }, 500);
}

// ══════════════════════════════════════════
//   ✅ PRINT ALL — loop + SweetAlert each
// ══════════════════════════════════════════
async function printAllCertificates() {
    if (allStudents.length === 0) {
        Swal.fire({ icon: 'warning', title: 'មិនមានសិស្ស!', timer: 1500, showConfirmButton: false });
        return;
    }

    const confirmAll = await Swal.fire({
        icon: 'question',
        title: `បោះពុម្ព ${allStudents.length} នាក់?`,
        text: 'វានឹងបោះពុម្ព Certificate សម្រាប់សិស្សទាំងអស់មួយម្នាក់ម្តង',
        showCancelButton:   true,
        confirmButtonText:  '<i class="bi bi-printer-fill me-1"></i> បាទ ចាប់ផ្តើម',
        cancelButtonText:   'បោះបង់',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor:  '#6c757d',
    });
    if (!confirmAll.isConfirmed) return;

    const today   = new Date();
    const months  = ['January','February','March','April','May','June',
                     'July','August','September','October','November','December'];
    const granted = months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear();

    // ✅ បើក modal មួយដង
    const modalEl = document.getElementById('certModal');
    const modal   = new bootstrap.Modal(modalEl, { backdrop: false, keyboard: false });
    modal.show();

    // ✅ រង់ចាំ modal បើករួច
    await new Promise(resolve => setTimeout(resolve, 400));

    let savedCount = 0;
    let failCount  = 0;

    for (let i = 0; i < allStudents.length; i++) {
        const s      = allStudents[i];
        const course = s.course || currentClass.course;
        const certId = ($('#cert_id_value').val() || $('#certId').text() || '').trim();

        // Fill preview
        $('#current_student_id').val(s.id);
        $('#edit_student_name').val(s.name);
        $('#edit_course').val(course);
        // if (!$('#edit_granted').val()) {
        //     $('#edit_granted').val(granted);
        // }
        // $('#edit_id').val(certId);
        updatePreview();

        
        // ✅ រង់ចាំ preview update
        await new Promise(resolve => setTimeout(resolve, 300));

        // Print
        window.print();

        // Ask per student
        const res = await Swal.fire({
            icon: 'question',
            title: `[${i + 1}/${allStudents.length}] បោះពុម្ពជោគជ័យទេ?`,
            html: `<b>${escapeHtml(s.name)}</b><br><small class="text-muted">${escapeHtml(course)}</small>`,
            showCancelButton:   true,
            confirmButtonText:  '<i class="bi bi-check-lg me-1"></i> បាទ ជោគជ័យ',
            cancelButtonText:   '<i class="bi bi-x-lg me-1"></i> ទេ មានបញ្ហា',
            confirmButtonColor: '#198754',
            cancelButtonColor:  '#dc3545',
        });

        if (res.isConfirmed) {
            try {
                const saveRes = await saveCertificateToDB(s.id, s.name, course, granted, certId);
                if (saveRes.ok) {
                    savedCount++;
                    markStudentPrinted((saveRes.data && saveRes.data.student_id) ? saveRes.data.student_id : s.id);
                } else failCount++;
            } catch(e) { failCount++; }
        } else {
            failCount++;
        }
    }

    // ✅ បិទ modal នៅចុងក្រោយ
    modal.hide();

    Swal.fire({
        icon: savedCount > 0 ? 'success' : 'warning',
        title: 'រួចរាល់ទាំងអស់!',
        html: `
            <div class="d-flex justify-content-center gap-4 mt-2">
                <div><span class="fs-4 fw-bold text-success">${savedCount}</span><br><small>រក្សាទុករួច ✅</small></div>
                <div><span class="fs-4 fw-bold text-danger">${failCount}</span><br><small>មិនបានរក្សា ❌</small></div>
            </div>`,
        confirmButtonText: 'បិទ'
    });
}

// ══════════════════════════════════════════
//   Helpers
// ══════════════════════════════════════════
function showError(msg) {
    $('#student_list').html(`
        <tr><td colspan="7" class="text-center py-4 text-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>${msg}
        </td></tr>`);
}

function markPrintedRowsFromServer(classId) {
    $.ajax({
        url: "<?= base_url('api/certificate/printed-normal') ?>",
        method: "GET",
        data: { class_id: classId },
        dataType: "json",
        success: function (result) {
            if (!result.ok || !result.data || !Array.isArray(result.data.student_ids)) return;
            result.data.student_ids.forEach(function (id) {
                markStudentPrinted(parseInt(id, 10));
            });
        }
    });
}

function markStudentPrinted(studentId) {
    const row = $(`#student_list tr[data-student-id="${studentId}"]`);
    if (!row.length) return;
    if (row.hasClass('student-printed')) return;

    row.addClass('student-printed');
    if (remainingStudents > 0) remainingStudents--;
    updateStudentCount();

    const studentName = row.find('.student-name-text').text().trim();
    const course = row.find('td').eq(4).text().trim();
    const actionCell = row.find('td.text-center.no-print');

    actionCell.html(`
        <div class="print-actions">
            <button type="button" class="btn-print-done text-white" disabled>
                <i class="bi bi-check-circle-fill"></i> Printed
            </button>
            <button type="button" class="btn-print-again text-white">
                <i class="bi bi-printer-fill"></i> Re-print
            </button>
        </div>
    `);

    actionCell.find('.btn-print-again').on('click', function () {
        openCertificate(studentId, studentName, course, currentClass.teacher, currentClass.time);
    });
}

function updateStudentCount() {
    $('#student_count').text(remainingStudents + ' នាក់');
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>
