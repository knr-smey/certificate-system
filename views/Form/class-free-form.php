<?php
  
    $csrfToken              = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrfToken;
?>
<link rel="stylesheet" href="<?php echo e(base_url('assets/css/forms/class-free-form.css')) ?>">

<div class="form-container">
    <div class="form-header">
        <div class="form-logo">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="logo-img">
        </div>
        <h2>Certificate Request</h2>
        <p>Complete the form below to get your certificate</p>
    </div>

    <form method="POST" action="/form/certificate/submit">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken) ?>">

        <div class="form-group">
            <label for="student_name">Full Name</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your full name" oninput="this.value = this.value.toUpperCase()" >
        </div>

        <div class="form-group">
            <label for="course">Course</label>
            <select id="course" name="course" >
                <option value="">Select  course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo htmlspecialchars($course) ?>"><?php echo htmlspecialchars($course) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="submit-btn">Get Certificate</button>
    </form>
</div>
