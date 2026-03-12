<?php
// Use generatedId passed from controller, or generate one if not provided
if (!isset($generatedId) || empty($generatedId)) {
    require_once __DIR__ . '/../../../app/Helper/certificate-helper.php';
    $generatedId = generateCertificateId();
}
?>
<div class="form-card">

    <?php if (! empty($message)): ?>
        <div class="form-message">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/form/submit" novalidate id="classFreeForm" class="modern-form">

        <input type="hidden" id="generated_cert_id" value="<?php echo htmlspecialchars($generatedId) ?>">

        <!-- Row 1: Student Name + Course Text Input -->
        <div class="form-row-custom">
            <div class="form-group">
                <label for="student_name">
                    <i class="bi bi-person-fill me-2"></i>ឈ្មោះពេញជាឡាតាំង <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-person-badge"></i></span>
                    <input type="text" id="student_name" name="student_name"
                        placeholder="Ex. PHEAROM RATHA"
                        value="<?php echo htmlspecialchars($old['student_name'] ?? '') ?>"
                        oninput="this.value = this.value.toUpperCase()"
                        class="<?php echo isset($errors['student_name']) ? 'error' : '' ?>"
                        autocomplete="name"
                    >
                </div>
                <?php if (isset($errors['student_name'])): ?>
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle-fill me-1"></i>
                        <?php echo htmlspecialchars($errors['student_name']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="course">
                    <i class="bi bi-book-fill me-2"></i>វគ្គសិក្សា <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-code-slash"></i></span>
                    <input type="text" id="course" name="course"
                        placeholder="Ex. PHP/Laravel"
                        value="<?php echo htmlspecialchars($old['course'] ?? '') ?>"
                        class="<?php echo isset($errors['course']) ? 'error' : '' ?>"
                        autocomplete="off"
                    >
                </div>
                <?php if (isset($errors['course'])): ?>
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle-fill me-1"></i>
                        <?php echo htmlspecialchars($errors['course']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Row 2: Course Dropdown + End Date + Print Button -->
        <div class="form-row-custom form-row-three">
            <div class="form-group">
                <label for="course_filter">
                    <i class="bi bi-list-ul me-2"></i>ជ្រើសរើសវគ្គសិក្សា
                </label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-filter"></i></span>
                    <select id="course_filter" name="course_filter"
                        class="<?php echo isset($errors['course_filter']) ? 'error' : '' ?>">
                        <option value="">-- ជ្រើសរើសវគ្គសិក្សា --</option>
                        <?php if (isset($courses) && is_array($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <option value="<?= htmlspecialchars($c['course_name']) ?>">
                                    <?= htmlspecialchars($c['course_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="end_date">
                    <i class="bi bi-calendar-event-fill me-2"></i>ថ្ងៃបញ្ចប់វគ្គសិក្សា <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-calendar3"></i></span>
                    <input type="date" id="end_date" name="end_date"
                        value="<?php echo htmlspecialchars($old['end_date'] ?? '') ?>"
                        class="<?php echo isset($errors['end_date']) ? 'error' : '' ?>"
                    >
                </div>
                <?php if (isset($errors['end_date'])): ?>
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle-fill me-1"></i>
                        <?php echo htmlspecialchars($errors['end_date']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group form-group-btn">
                <label>&nbsp;</label>
                <button type="button" class="btn-cert-free-print text-white"
                    id="btnPrintCertificate" onclick="handlePrint()">
                    <i class="bi bi-printer-fill me-2"></i> បោះពុម្ព
                </button>
            </div>
        </div>

    </form>
</div>

<script>
// Base URL for API calls - ensure it always has a leading slash
// Use absolute path for API calls - no dynamic base URL needed
const API_BASE_URL = '/certificate-sys';

// Debug: Log the API base URL
console.log('API_BASE_URL:', API_BASE_URL);

let courseTypingTimer;
const courseTypingDelay = 800;

let courseDropdownRefreshTimer;
const courseDropdownRefreshDelay = 1500; // Refresh dropdown from DB every 1.5s while typing

function saveCourseToDB(courseName) {
    fetch(API_BASE_URL + '/api/course/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ course_name: courseName.trim() })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success === true) {
            refreshCourseDropdown(courseName.trim());
        }
    })
    .catch(err => console.error('Error saving course:', err));
}

function refreshCourseDropdown(autoSelectValue = null) {
    const apiUrl = API_BASE_URL + '/api/course/list';
    console.log('Fetching courses from:', apiUrl);
    
    fetch(apiUrl)
    .then(res => {
        if (!res.ok) {
            throw new Error('HTTP error! status: ' + res.status);
        }
        return res.json();
    })
    .then(data => {
        const courseFilterSelect = document.getElementById('course_filter');
        if (!courseFilterSelect) return;
        
        // Rebuild options from database
        courseFilterSelect.innerHTML = '<option value="">-- ជ្រើសរើសវគ្គសិក្សា --</option>';
        
        if (data.courses && Array.isArray(data.courses)) {
            data.courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.course_name;
                option.textContent = course.course_name;
                courseFilterSelect.appendChild(option);
            });
        }
        
        // Auto-select if value provided
        if (autoSelectValue) {
            const options = courseFilterSelect.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value.toUpperCase() === autoSelectValue.toUpperCase()) {
                    courseFilterSelect.value = options[i].value;
                    break;
                }
            }
        }
    })
    .catch(err => {
        console.error('Error loading courses:', err);
        // Show user-friendly error
        const courseFilterSelect = document.getElementById('course_filter');
        if (courseFilterSelect) {
            courseFilterSelect.innerHTML = '<option value="">-- មិនអាចផ្ទុកទិន្នន័យ --</option>';
        }
        console.error('Error loading courses: ' + err.message + '\nAPI URL: ' + apiUrl);
    });
}

function formatCertificateDate(dateString, cutoffDay = 10, certificateDay = 15) {
    if (!dateString) return '';
    const selectedDate = new Date(dateString);
    if (isNaN(selectedDate.getTime())) return dateString;

    const selectedDay = selectedDate.getDate();
    let year  = selectedDate.getFullYear();
    let month = selectedDate.getMonth();

    if (selectedDay <= cutoffDay) {
        month--;
        if (month < 0) { month = 11; year--; }
    }

    const months = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];
    return `${months[month]} ${certificateDay},${year}`;
}

const CertificateStorage = {
    saveCourse:  function(v) { localStorage.setItem('certificate_course', v); },
    getCourse:   function()  { return localStorage.getItem('certificate_course'); },
    saveEndDate: function(v) { localStorage.setItem('certificate_end_date', v); },
    getEndDate:  function()  { return localStorage.getItem('certificate_end_date'); }
};

const FormValidator = {
    validateRequired: function(fieldIds) {
        let isValid = true;
        fieldIds.forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;

            input.classList.remove('error');
            const formGroup = input.closest('.form-group');
            const oldError  = formGroup ? formGroup.querySelector('.error-message') : null;
            if (oldError) oldError.remove();

            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('error');
                if (formGroup) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    const fieldNames = {
                        'student_name': 'Full Name is required!',
                        'course':       'Course is required!',
                        'end_date':     'End Date is required!'
                    };
                    errorMsg.innerHTML = `<i class="bi bi-exclamation-circle-fill me-1"></i>${fieldNames[id] || 'This field is required!'}`;
                    formGroup.appendChild(errorMsg);
                }
            }
        });
        return isValid;
    }
};

const fields = ['student_name', 'course', 'end_date'];

function validateForm() {
    return FormValidator.validateRequired(fields);
}

window.validateBeforePrint = function() {
    return validateForm();
};

// Clear errors on input/change
fields.forEach(id => {
    const input = document.getElementById(id);
    if (!input) return;
    const formGroup = input.closest('.form-group');
    const eventType = input.type === 'date' ? 'change' : 'input';
    input.addEventListener(eventType, function() {
        if (this.value.trim() !== '') {
            this.classList.remove('error');
            const oldError = formGroup ? formGroup.querySelector('.error-message') : null;
            if (oldError) oldError.remove();
        }
    });
});

// ── Single DOMContentLoaded ──────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {

    // Certificate ID
    const certIdInput = document.getElementById('generated_cert_id');
    const certIdVal   = document.getElementById('cert_id_val_free');
    if (certIdInput && certIdVal) {
        certIdVal.textContent = certIdInput.value;
    }

    // Certificate preview elements
    const certStudentName = document.getElementById('cert_student_name_free');
    const certCourse      = document.getElementById('cert_course_free');
    const certTime        = document.getElementById('cert_time_free');

    // Load saved course (only if input is empty)
    const courseInput = document.getElementById('course');
    const savedCourse = CertificateStorage.getCourse();
    if (savedCourse && courseInput && !courseInput.value) {
        courseInput.value = savedCourse;
        if (certCourse) certCourse.textContent = savedCourse.toUpperCase();
    }

    // End Date: default to TODAY if empty
    const endDateInput = document.getElementById('end_date');
    if (endDateInput) {
        if (!endDateInput.value) {
            const today = new Date();
            const yyyy  = today.getFullYear();
            const mm    = String(today.getMonth() + 1).padStart(2, '0');
            const dd    = String(today.getDate()).padStart(2, '0');
            endDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
        if (certTime) {
            certTime.textContent = formatCertificateDate(endDateInput.value);
        }
        CertificateStorage.saveEndDate(endDateInput.value);
    }

    // Student Name live update
    const studentNameInput = document.getElementById('student_name');
    if (studentNameInput && certStudentName) {
        studentNameInput.addEventListener('input', function(e) {
            certStudentName.textContent = e.target.value.toUpperCase();
        });
    }

    // Course text input live update
    if (courseInput && certCourse) {
        courseInput.addEventListener('input', function(e) {
            const val = e.target.value;
            certCourse.textContent = val.toUpperCase();
            CertificateStorage.saveCourse(val);
            
            // Debounced auto-save to DB and refresh dropdown while typing
            // clearTimeout(courseTypingTimer);
            // if (val.trim().length >= 2) {
            //     courseTypingTimer = setTimeout(function() {
            //         // Save to database
            //         fetch(API_BASE_URL + '/api/course/save', {
            //             method: 'POST',
            //             headers: { 'Content-Type': 'application/json' },
            //             body: JSON.stringify({ course_name: val.trim() })
            //         })
            //         .then(res => res.json())
            //         .then(data => {
            //             // After saving, refresh dropdown from database
            //             refreshCourseDropdown(val.trim());
            //         })
            //         .catch(err => console.error('Error saving course:', err));
            //     }, courseTypingDelay);
            // }
        });
        
        // Save to DB immediately when user leaves the field
        // courseInput.addEventListener('blur', function(e) {
        //     const val = e.target.value.trim();
        //     if (val.length >= 2) {
        //         clearTimeout(courseTypingTimer);
        //         fetch(API_BASE_URL + '/api/course/save', {
        //             method: 'POST',
        //             headers: { 'Content-Type': 'application/json' },
        //             body: JSON.stringify({ course_name: val })
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             refreshCourseDropdown(val);
        //         })
        //         .catch(err => console.error('Error saving course:', err));
        //     }
        // });
    }

    // Course dropdown → fill text input
    const courseFilterSelect = document.getElementById('course_filter');
    if (courseFilterSelect && courseInput && certCourse) {
        courseFilterSelect.addEventListener('change', function(e) {
            const selected = e.target.value;
            if (selected) {
                courseInput.value = selected;
                certCourse.textContent = selected.toUpperCase();
                CertificateStorage.saveCourse(selected);
                clearTimeout(courseTypingTimer); // prevent re-saving selected value
            }
        });
    }

    // End Date live update
    if (endDateInput && certTime) {
        endDateInput.addEventListener('change', function(e) {
            certTime.textContent = formatCertificateDate(e.target.value);
            CertificateStorage.saveEndDate(e.target.value);
        });
    }
    
    // Refresh course dropdown on load
    refreshCourseDropdown(courseInput ? courseInput.value : null);

    // Handle Print button click - Save to DB first, then print
    window.handlePrint = function() {
        // Validate required fields
        const studentName = document.getElementById('student_name');
        const course = document.getElementById('course');
        const endDate = document.getElementById('end_date');
        
        let isValid = true;
        
        // Check student_name
        if (!studentName || studentName.value.trim() === '') {
            isValid = false;
            studentName.classList.add('error');
            if (studentName.closest('.form-group')) {
                let errorDiv = studentName.closest('.form-group').querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>Full Name is required!';
                    studentName.closest('.form-group').appendChild(errorDiv);
                }
            }
        }
        
        // Check course
        if (!course || course.value.trim() === '') {
            isValid = false;
            course.classList.add('error');
            if (course.closest('.form-group')) {
                let errorDiv = course.closest('.form-group').querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>Course is required!';
                    course.closest('.form-group').appendChild(errorDiv);
                }
            }
        }
        
        // Check end_date
        if (!endDate || endDate.value.trim() === '') {
            isValid = false;
            endDate.classList.add('error');
            if (endDate.closest('.form-group')) {
                let errorDiv = endDate.closest('.form-group').querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>End Date is required!';
                    endDate.closest('.form-group').appendChild(errorDiv);
                }
            }
        }
        
        if (!isValid) {
            return false;
        }
        
        // Submit form data via AJAX first
        const formData = new FormData();
        formData.append('student_name', studentName.value.trim());
        formData.append('course', course.value.trim());
        formData.append('end_date', endDate.value);
        
        // Show loading indicator
        const printBtn = document.getElementById('btnPrintCertificate');
        const originalText = printBtn.innerHTML;
        printBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> កំពុងរក្សាទុក...​';
        printBtn.disabled = true;
        
        fetch('/form/submit', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            // After successful save, trigger print
            printBtn.innerHTML = originalText;
            printBtn.disabled = false;
            
            // Call the print function from app.js
            if (typeof printCertificate === 'function') {
                printCertificate();
            } else {
                // Fallback to window.print()
                window.print();
            }
        })
        .catch(err => {
            console.error('Error saving certificate:', err);
            printBtn.innerHTML = originalText;
            printBtn.disabled = false;
            alert('Error saving certificate. Please try again.');
        });
        
        return false;
    };
});
</script>