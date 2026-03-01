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

        <div class="form-row">
            <div class="form-group">
                <label for="student_name">
                    <i class="bi bi-person-fill me-2"></i>ឈ្មោះពេញជាឡាតាំង <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="bi bi-person-badge"></i></span>
                    <input type="text" id="student_name" name="student_name" placeholder="Ex. PHEAROM RATHA"
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
                    <input type="text" id="course" name="course" placeholder="Ex. PHP/Laravel"
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
                <div class="d-flex gap-2">
                   <button type="button" class="btn-cert-free-print text-white" id="btnPrintCertificate" onclick="handlePrint()">
                        <i class="bi bi-printer-fill me-2"></i> បោះពុម្ព
                    </button>
              
                </div>
             
            </div>
        </div>
    </form>
</div>

<script>
// ============================================
// Certificate Helper Functions (inline)
// ============================================

/**
 * Format date for certificate display
 * Matches the PHP getCertificateDate() logic
 */
function formatCertificateDate(dateString, cutoffDay = 10, certificateDay = 15) {
    if (!dateString) return '';
    
    const selectedDate = new Date(dateString);
    if (isNaN(selectedDate.getTime())) return dateString;
    
    const selectedDay = selectedDate.getDate();
    let year = selectedDate.getFullYear();
    let month = selectedDate.getMonth();
    
    if (selectedDay <= cutoffDay) {
        month--;
        if (month < 0) {
            month = 11;
            year--;
        }
    }
    
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                    'July', 'August', 'September', 'October', 'November', 'December'];
    const monthName = months[month];
    
    return `${monthName} ${certificateDay},${year}`;
}

/**
 * Local Storage helpers for certificate data persistence
 */
const CertificateStorage = {
    saveCourse: function(course) {
        localStorage.setItem('certificate_course', course);
    },
    getCourse: function() {
        return localStorage.getItem('certificate_course');
    },
    saveEndDate: function(date) {
        localStorage.setItem('certificate_end_date', date);
    },
    getEndDate: function() {
        return localStorage.getItem('certificate_end_date');
    }
};

/**
 * Form validation helpers
 */
const FormValidator = {
    validateRequired: function(fieldIds) {
        let isValid = true;
        
        fieldIds.forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;
            
            input.classList.remove('error');
            const formGroup = input.closest('.form-group');
            const oldError = formGroup ? formGroup.querySelector('.error-message') : null;
            if (oldError) oldError.remove();

            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('error');
                
                if (formGroup) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message';
                    const fieldNames = {
                        'student_name': 'Full Name is required!',
                        'course': 'Course is required!',
                        'end_date': 'End Date is required!'
                    };
                    errorMsg.innerHTML = `<i class="bi bi-exclamation-circle-fill me-1"></i>${fieldNames[id] || 'This field is required!'}`;
                    formGroup.appendChild(errorMsg);
                }
            }
        });
        
        return isValid;
    }
};

const form = document.getElementById('classFreeForm');
const fields = ['student_name', 'course', 'end_date'];

// ============================================
// Local Storage for Course - Persist across sessions
// ============================================

// Load course from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set certificate ID from hidden input
    const certIdInput = document.getElementById('generated_cert_id');
    const certIdVal = document.getElementById('cert_id_val_free');
    if (certIdInput && certIdVal) {
        certIdVal.textContent = certIdInput.value;
    }
    
    const courseInput = document.getElementById('course');
    const certCourse = document.getElementById('cert_course_free');
    
    // Load saved course from localStorage
    const savedCourse = CertificateStorage.getCourse();
    if (savedCourse && courseInput) {
        courseInput.value = savedCourse;
        // Also update certificate preview
        if (certCourse) {
            certCourse.textContent = savedCourse.toUpperCase();
        }
    }
    
    // Load saved end_date from localStorage
    const savedEndDate = CertificateStorage.getEndDate();
    const endDateInput = document.getElementById('end_date');
    const certTime = document.getElementById('cert_time_free');
    
    if (savedEndDate && endDateInput) {
        endDateInput.value = savedEndDate;
        // Also update certificate preview
        if (certTime) {
            certTime.textContent = formatCertificateDate(savedEndDate);
        }
    }
});

// Function to validate form and show errors under inputs
function validateForm() {
    return FormValidator.validateRequired(fields);
}

// Expose validation for certificate handler
window.validateBeforePrint = function() {
    return validateForm();
};

// Clear errors on input/change
fields.forEach(id => {
    const input = document.getElementById(id);
    const formGroup = input.closest('.form-group');
    const eventType = input.type === 'date' ? 'change' : 'input';
    input.addEventListener(eventType, function() {
        if (this.value.trim() !== '') {
            this.classList.remove('error');
            const oldError = formGroup.querySelector('.error-message');
            if (oldError) oldError.remove();
        }
    });
});

// Wrapper function to match the existing formatDate usage
// Uses the helper function with default parameters matching PHP helper
function formatDate(dateString) {
    return formatCertificateDate(dateString);
}

// Wait for DOM to be fully loaded before setting up auto-update
document.addEventListener('DOMContentLoaded', function() {
    // Get certificate elements
    const certStudentName = document.getElementById('cert_student_name_free');
    const certCourse = document.getElementById('cert_course_free');
    const certTime = document.getElementById('cert_time_free');

    // Student Name - auto update on input
    const studentNameInput = document.getElementById('student_name');
    if (studentNameInput && certStudentName) {
        studentNameInput.addEventListener('input', function(e) {
            certStudentName.textContent = e.target.value.toUpperCase();
        });
    }

    // Course - auto update on input and save to localStorage
    const courseInput = document.getElementById('course');
    if (courseInput && certCourse) {
        courseInput.addEventListener('input', function(e) {
            const courseValue = e.target.value;
            certCourse.textContent = courseValue.toUpperCase();
            // Save course to localStorage for next session
            CertificateStorage.saveCourse(courseValue);
        });
    }

    // End Date - auto update on change and save to localStorage
    const endDateInput = document.getElementById('end_date');
    if (endDateInput && certTime) {
        endDateInput.addEventListener('change', function(e) {
            const dateValue = e.target.value;
            certTime.textContent = formatCertificateDate(dateValue);
            // Save end_date to localStorage for next session
            CertificateStorage.saveEndDate(dateValue);
        });
    }
});
</script>