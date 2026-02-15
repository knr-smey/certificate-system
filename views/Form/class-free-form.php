<?php
$message = $_SESSION['form_message'] ?? '';
unset($_SESSION['form_message']); 
?>

<link rel="stylesheet" href="assets/css/forms/class-free-form.css">

<div class="form-container">
    <div class="form-header">
        <div class="form-logo">
            <img src="assets/images/logo.png" alt="Logo" class="logo-img">
        </div>
        <h2>Certificate Request</h2>
        <p>Complete the form below to get your certificate</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="form-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="/form/submit">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

        <div class="form-group">
            <label for="student_name">Full Name</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your full name" required oninput="this.value = this.value.toUpperCase()">
        </div>

        <div class="form-group">
            <label for="course">Course</label>
            <select id="course" name="course" required>
                <option value="">Select course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="submit-btn">Get Certificate</button>
    </form>
</div>
