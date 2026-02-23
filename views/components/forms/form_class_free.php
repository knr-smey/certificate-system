<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-icon">
            <i class="bi bi-award-fill"></i>
        </div>
        <div>
            <div class="form-card-title">ទម្រង់ស្នើរសុំសញ្ញាប័ត្រ</div>
            <div class="form-card-subtitle">Certificate Request Form</div>
        </div>
    </div>

    <?php if (! empty($message)): ?>
        <div class="form-message">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/form/submit" novalidate id="classFreeForm" class="modern-form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken) ?>">

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
                <button type="submit" class="submit-btn">
                 បញ្ជូន
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

// Save course to localStorage when form is submitted
form.addEventListener('submit', function(e) {
    const courseInput = document.getElementById('course');
    if (courseInput.value.trim() !== '') {
        // Save course to localStorage
        localStorage.setItem('certificate_course', courseInput.value.trim());
    }
});

form.addEventListener('submit', function(e) {
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

            // Append to form-group, not input-wrapper, to keep icon position stable
            formGroup.appendChild(errorMsg);
        }
    });

    if (!isValid) e.preventDefault();
});

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
</script>
