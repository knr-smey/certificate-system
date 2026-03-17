<div class="container-fluid py-4 px-4" id="print_area">

    <!-- Back + Print Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="javascript:history.back()" class="btn-back">
            <i class="bi bi-arrow-left-circle-fill me-2"></i>ត្រឡប់ក្រោយ
        </a>
        <div class="page-badge text-white">
            <i class="bi bi-award-fill me-2"></i>បញ្ជីសិស្សសញ្ញាបត្រ
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

                    <!-- Student Name -->
                    <div class="cert-field-group">
                        <label class="cert-field-label">ឈ្មោះសិស្ស</label>
                        <input type="text" id="edit_student_name" class="cert-field-input"
                               placeholder="Student name...">
                    </div>

                    <!-- Course Input -->
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

                    <!-- Granted Date -->
                    <div class="cert-field-group">
                        <label class="cert-field-label">ថ្ងៃខែឆ្នាំ / Granted Date</label>
                        <input type="text" id="edit_granted" class="cert-field-input"
                               placeholder="e.g. February 17, 2026">
                    </div>

                    <!-- ID -->
                    <div class="cert-field-group">
                        <label class="cert-field-label">លេខ ID</label>
                        <div class="d-flex gap-2">
                            <input type="text" id="edit_id" class="cert-field-input"
                                   placeholder="Auto-generated">
                            <button class="cert-btn-regen" onclick="regenId()"
                                    title="Generate new ID" type="button">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>

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
/* Select dropdown styling */
#saved_courses_select {
    cursor: pointer;
}
#saved_courses_select option {
    padding: 8px;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
let currentClass = { course: '-', teacher: '-', time: '-' };

// ── localStorage key ──
const LS_KEY = 'cert_saved_courses_v2';

// ══════════════════════════════════════════
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
                    </td></tr>
                `);
                $('#student_count').text('0 នាក់');
                return;
            }

            $('#student_count').text(result.data.length + ' នាក់');

            const rows = result.data.map((s) => {
                const gender = s.gender || 'Male';
                const gClass = gender === 'Female' ? 'gender-f' : 'gender-m';
                const score  = parseInt(s.score) || 0;
                const sCls   = score >= 70 ? 'score-high' : score >= 50 ? 'score-mid' : 'score-low';
                const course = s.course || currentClass.course;

                return `
                <tr>
                    <td class="text-center">
                        <span class="row-no text-white">${s.id}</span>
                    </td>
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
                    <td>${course}</td>
                    <td class="text-center no-print">
                        <button class="btn-print-cert text-white"
                            onclick="openCertificate(
                                '${escapeHtml(s.name)}',
                                '${escapeHtml(course)}',
                                '${escapeHtml(currentClass.teacher)}',
                                '${escapeHtml(currentClass.time)}',
                                ${score})">
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

// ══════════════════════════════════════════
//   Open Certificate Modal
// ══════════════════════════════════════════
function openCertificate(name, course, teacher, time, score) {
    $('#edit_student_name').val(name);
    $('#edit_course').val(course);

    // Auto date
    const today  = new Date();
    const months = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];
    const granted = months[today.getMonth()] + ' ' + today.getDate() + ', ' + today.getFullYear();
    $('#edit_granted').val(granted);

    // Auto ID
    $('#edit_id').val(generateId());

    updatePreview();
    renderSavedCourses();
    new bootstrap.Modal(document.getElementById('certModal')).show();
}

// ── Live preview update ──
$(document).on('input', '#edit_student_name, #edit_course, #edit_granted, #edit_id', function () {
    updatePreview();
    // Re-render dropdown to update selected highlight
    if ($(this).attr('id') === 'edit_course') {
        renderSavedCourses();
    }
});

function updatePreview() {
    $('#cert_student_name').text($('#edit_student_name').val() || '—');
    $('#cert_course').text($('#edit_course').val()             || '—');
    $('#cert_time').text($('#edit_granted').val()              || '—');
    $('#cert_id_val').text($('#edit_id').val()                 || '—');
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
    $('#edit_id').val(generateId());
    updatePreview();
}

// ══════════════════════════════════════════
//   localStorage — Course Management
// ══════════════════════════════════════════

function getSavedCourses() {
    try { return JSON.parse(localStorage.getItem(LS_KEY)) || []; }
    catch(e) { return []; }
}

// Save course — បន្ថែម មិនជំនួស
function saveCourse() {
    const custom = $('#edit_course').val().trim();
    // if (!custom) return;

    // let list   = getSavedCourses();
    // const exists = list.some(c => c.toLowerCase() === custom.toLowerCase());

    // if (!exists) {
    //     list.push(custom);
    //     localStorage.setItem(LS_KEY, JSON.stringify(list));
    // }

    // renderSavedCourses();

    // // Flash feedback
    // const btn = $('.btn-cert-save');
    // if (exists) {
    //     btn.html('<i class="bi bi-exclamation-circle-fill me-2"></i>មានរួចហើយ!');
    // } else {
    //     btn.html('<i class="bi bi-check-circle-fill me-2"></i>រក្សាទុករួច!');
    // }
    // setTimeout(() => btn.html('<i class="bi bi-bookmark-fill me-2"></i>រក្សាទុក Course'), 1800);

    $.ajax({
        url: "<?= base_url('api/course/savenormal') ?>",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ course_name: custom }),
        success: function (result) {
            if (result.success) {
                renderSavedCourses();
            } else {
                alert('មានបញ្ហា៖ ' + (result.message || 'Unknown error'));
            }
        },
        error: function () {
            alert('Server error while saving course');
        }
    });
}

// Render dropdown
function renderSavedCourses() {
    // const list = getSavedCourses();

    // $('#saved_count').text(list.length);

    // if (list.length === 0) {
    //     $('#saved_courses_wrap').hide();
    //     return;
    // }

    // $('#saved_courses_wrap').show();

    // const currentVal = $('#edit_course').val().trim().toLowerCase();

    // let options = `<option value="">-- ជ្រើសរើស Course --</option>`;
    // options += list.map(c => {
    //     const selected = c.toLowerCase() === currentVal ? 'selected' : '';
    //     return `<option value="${escapeHtml(c)}" ${selected}>${escapeHtml(c)}</option>`;
    // }).join('');

    $.ajax({
        url: "<?= base_url('api/course/listnormal') ?>",
        method: "GET",
        dataType: "json",
        success: function (result) {
            const courses = result.courses || [];
            console.log('Fetched courses:', courses);
            $('#saved_count').text(courses.length);
            if (courses.length === 0) {
                $('#saved_courses_wrap').hide();
                return;
            }
            $('#saved_courses_wrap').show();

            const currentVal = $('#edit_course').val().trim().toLowerCase();

            let options = `<option value="">-- ជ្រើសរើស Course --</option>`;
            options += courses.map(c => {
                const courseName = typeof c === 'object' ? c.course_name : c;

                const selected = courseName.toLowerCase() === currentVal
                    ? 'selected'
                    : '';

                return `<option value="${escapeHtml(courseName)}" ${selected}>
                            ${escapeHtml(courseName)}
                        </option>`;
            }).join('');

            $('#saved_courses_select').html(options);
        },
        error: function () {
            alert('Server error while fetching courses');
        }
    });

    // $('#saved_courses_select').html(options); // Removed: 'options' is only defined in AJAX callback
}

// Apply selected course from dropdown
function applySavedCourseFromSelect(value) {
    if (!value) return;
    $('#edit_course').val(value);
    updatePreview();
}

// Delete selected course from dropdown
// function deleteSelectedCourse() {
//     const val = $('#saved_courses_select').val();
//     if (!val) {
//         alert('សូមជ្រើសរើស Course មុនសិន!');
//         return;
//     }

//     let list = getSavedCourses();
//     list = list.filter(c => c.toLowerCase() !== val.toLowerCase());
//     localStorage.setItem(LS_KEY, JSON.stringify(list));

//     // Clear input if deleted course was active
//     if ($('#edit_course').val().trim().toLowerCase() === val.toLowerCase()) {
//         $('#edit_course').val('');
//         updatePreview();
//     }

//     renderSavedCourses();
// }

function deleteSelectedCourse() {
    const val = $('#saved_courses_select').val();

    if (!val) {
        alert('សូមជ្រើសរើស Course មុនសិន!');
        return;
    }

    // confirm before delete (optional but good)
    // if (!confirm('Are you sure to delete this course?')) return;

    $.ajax({
        url: "<?= base_url('api/course/delete') ?>",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ course_name: val }),

        success: function (res) {
            if (res.success) {
                // clear input if same
                if ($('#edit_course').val().trim().toLowerCase() === val.toLowerCase()) {
                    $('#edit_course').val('');
                    updatePreview();
                }

                renderSavedCourses(); // refresh dropdown ✅
            } else {
                alert('Delete failed: ' + (res.message || 'Unknown error'));
            }
        },

        error: function () {
            alert('Server error while deleting course');
        }
    });
}

// ══════════════════════════════════════════
//   Print
// ══════════════════════════════════════════
function printCertificateStudent() {
    window.print();
}

// ══════════════════════════════════════════
//   Helpers
// ══════════════════════════════════════════
function showError(msg) {
    $('#student_list').html(`
        <tr><td colspan="7" class="text-center py-4 text-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>${msg}
        </td></tr>
    `);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>