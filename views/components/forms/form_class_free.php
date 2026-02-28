<div class="form-card">

    <?php if (! empty($message)): ?>
        <div class="form-message">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/form/submit" novalidate id="classFreeForm" class="modern-form">

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
                   <button type="button" class="btn-cert-free-print text-white" id="btnPrintCertificate">
            <i class="bi bi-printer-fill me-2"></i> បោះពុម្ព
        </button>
            </div>
        </div>
    </form>
</div>

<script>
const form = document.getElementById('classFreeForm');
const fields = ['student_name', 'course', 'end_date'];

// Clear localStorage on page load to start fresh
localStorage.removeItem('certificate_course');

// Function to validate form and show errors under inputs
function validateForm() {
    let isValid = true;
    
    fields.forEach(id => {
        const input = document.getElementById(id);
        input.classList.remove('error');
        const formGroup = input.closest('.form-group');
        const oldError = formGroup.querySelector('.error-message');
        if (oldError) oldError.remove();

        if (input.value.trim() === '') {
            isValid = false;
            input.classList.add('error');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-message';

            if(id === 'student_name') errorMsg.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>Full Name is required!';
            if(id === 'course') errorMsg.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>Course is required!';
            if(id === 'end_date') errorMsg.innerHTML = '<i class="bi bi-exclamation-circle-fill me-1"></i>End Date is required!';

            formGroup.appendChild(errorMsg);
        }
    });
    
    return isValid;
}

// ============================================
// Print button click handler with validation
// ============================================
const printBtn = document.getElementById('btnPrintCertificate');
if (printBtn) {
    printBtn.addEventListener('click', function(e) {
        // Validate form before printing
        const isValid = validateForm();
        
        if (!isValid) {
            // Prevent printing if validation fails
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
        
        // Store validation state for certificate handler
        printBtn.dataset.validated = 'true';
    });
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

// ============================================
// Auto-update certificate preview on input
// ============================================

// Format date to match helper function logic (e.g., "March 15,2026")
// Uses the selected date's month/year but always uses day 15
function formatDate(dateString) {
    if (!dateString) return '';
    const selectedDate = new Date(dateString);
    if (isNaN(selectedDate.getTime())) return dateString;
    
    // Get the day from the selected date (same as PHP helper logic)
    const selectedDay = selectedDate.getDate();
    const cutoffDay = 10;
    
    let year = selectedDate.getFullYear();
    let month = selectedDate.getMonth(); // 0-11
    
    // If selected day <= cutoff day, go back one month from selected date
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
    const certificateDay = 15;
    
    return `${monthName} ${certificateDay},${year}`;
}

// Wait for DOM to be fully loaded before setting up auto-update
document.addEventListener('DOMContentLoaded', function() {
    // Get certificate elements
    const certStudentName = document.getElementById('cert_student_name');
    const certCourse = document.getElementById('cert_course');
    const certTime = document.getElementById('cert_time');

    // Student Name - auto update on input
    const studentNameInput = document.getElementById('student_name');
    if (studentNameInput && certStudentName) {
        studentNameInput.addEventListener('input', function(e) {
            certStudentName.textContent = e.target.value.toUpperCase() || 'PHEAROM RATHA';
        });
    }

    // Course - auto update on input
    const courseInput = document.getElementById('course');
    if (courseInput && certCourse) {
        courseInput.addEventListener('input', function(e) {
            certCourse.textContent = e.target.value.toUpperCase() || 'FREE HTML CSS TAILWIND';
        });
    }

    // End Date - auto update on change
    const endDateInput = document.getElementById('end_date');
    if (endDateInput && certTime) {
        endDateInput.addEventListener('change', function(e) {
            certTime.textContent = formatDate(e.target.value) || 'Auguest 15,2025';
        });
    }
});
</script>

