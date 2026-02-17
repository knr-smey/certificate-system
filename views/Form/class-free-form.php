<?php
$message = $_SESSION['form_message'] ?? '';
$errors = $errors ?? [];
$old = $old ?? [];
unset($_SESSION['form_message']); 
?>

<link rel="stylesheet" href="assets/css/class-free-form.css">

<div class="form-container">
    <div class="form-header">
        <div class="form-logo">
            <img src="assets/Images/logo.png" alt="Logo" class="logo-img">
        </div>
        <h2>Certificate Request</h2>
        <p>Complete the form below to get your certificate</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="form-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="/form/submit" novalidate id="classFreeForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

        <div class="form-group">
            <label for="student_name">Full Name</label>
            <input 
                type="text" 
                id="student_name" 
                name="student_name" 
                placeholder="Enter your full name"
                value="<?= htmlspecialchars($old['student_name'] ?? '') ?>"
                oninput="this.value = this.value.toUpperCase()"
                class="<?= isset($errors['student_name']) ? 'error' : '' ?>"
            >
            <?php if (isset($errors['student_name'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['student_name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="course">Course</label>
            <select 
                id="course" 
                name="course" 
                class="<?= isset($errors['course']) ? 'error' : '' ?>"
            >
                <option value="">Select course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= htmlspecialchars($course) ?>" <?= ($old['course'] ?? '') === $course ? 'selected' : '' ?>><?= htmlspecialchars($course) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['course'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['course']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="submit-btn">Get Certificate</button>
    </form>
</div>

<script>
document.getElementById('classFreeForm').addEventListener('submit', function(e) {
    let isValid = true;
    const studentName = document.getElementById('student_name');
    const course = document.getElementById('course');
    
    // Clear previous errors
    studentName.classList.remove('error');
    course.classList.remove('error');
    
    // Remove existing error messages
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Validate student name
    if (studentName.value.trim() === '') {
        studentName.classList.add('error');
        const errorMsg1 = document.createElement('div');
        errorMsg1.className = 'error-message';
        errorMsg1.textContent = 'Full Name is required!';
        studentName.parentElement.appendChild(errorMsg1);
        isValid = false;
    }
    
    // Validate course
    if (course.value === '') {
        course.classList.add('error');
        const errorMsg2 = document.createElement('div');
        errorMsg2.className = 'error-message';
        errorMsg2.textContent = 'Course is required!';
        course.parentElement.appendChild(errorMsg2);
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

// Clear error when user starts typing
document.getElementById('student_name').addEventListener('input', function() {
    if (this.value.trim() !== '') {
        this.classList.remove('error');
        const errorMsg = this.parentElement.querySelector('.error-message');
        if (errorMsg) errorMsg.remove();
    }
});

// Clear error when user selects a course
document.getElementById('course').addEventListener('change', function() {
    if (this.value !== '') {
        this.classList.remove('error');
        const errorMsg = this.parentElement.querySelector('.error-message');
        if (errorMsg) errorMsg.remove();
    }
});
</script>
