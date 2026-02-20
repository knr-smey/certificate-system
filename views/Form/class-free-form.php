<?php
    $message = $_SESSION['form_message'] ?? '';
    $errors  = $errors ?? [];
    $old     = $old ?? [];
    unset($_SESSION['form_message']);
?>

<link rel="stylesheet" href="assets/css/class-free-form.css">

<div class="form-container">
    <div class="form-header">
        <div class="form-logo">
            <img src="assets/Images/logo.png" alt="Logo" class="logo-img">
        </div>
        <h2>ទម្រង់ស្នើរសុំសញ្ញាប័ត្រ</h2>
        <p>សូមបំពេញទម្រង់ខាងក្រោម ដើម្បីស្នើរសុំសញ្ញាប័ត្របញ្ចប់វគ្គសិក្សា</p>
    </div>

    <?php if (! empty($message)): ?>
        <div class="form-message"><?php echo htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="/form/submit" novalidate id="classFreeForm">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken) ?>">

        <div class="form-group">
            <label for="student_name">ឈ្មោះពេញជាឡាតាំង <span class="required">*</span></label>
            <input type="text" id="student_name" name="student_name" placeholder="Ex. PHEAROM RATHA"
                value="<?php echo htmlspecialchars($old['student_name'] ?? '') ?>"
                oninput="this.value = this.value.toUpperCase()"
                class="<?php echo isset($errors['student_name']) ? 'error' : '' ?>"
                autocomplete="name"
            >
            <?php if (isset($errors['student_name'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['student_name']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="course">វគ្គសិក្សា <span class="required">*</span></label>
            <input type="text" id="course" name="course" placeholder="Ex. PHP/Laravel"
                value="<?php echo htmlspecialchars($old['course'] ?? '') ?>"
                class="<?php echo isset($errors['course']) ? 'error' : '' ?>"
                autocomplete="off"
            >
            <?php if (isset($errors['course'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['course']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="end_date">ថ្ងៃបញ្ចប់វគ្គសិក្សា <span class="required">*</span></label>
            <input type="date" id="end_date" name="end_date"
                value="<?php echo htmlspecialchars($old['end_date'] ?? '') ?>"
                class="<?php echo isset($errors['end_date']) ? 'error' : '' ?>"
            >
            <?php if (isset($errors['end_date'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['end_date']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="submit-btn">ស្នើរសុំ</button>
    </form>
</div>

<script>
const form = document.getElementById('classFreeForm');
const fields = ['student_name', 'course', 'end_date'];

form.addEventListener('submit', function(e) {
    let isValid = true;

    fields.forEach(id => {
        const input = document.getElementById(id);
        input.classList.remove('error');
        const oldError = input.parentElement.querySelector('.error-message');
        if (oldError) oldError.remove();

        if (input.value.trim() === '') {
            isValid = false;
            input.classList.add('error');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-message';

            if(id === 'student_name') errorMsg.textContent = 'Full Name is required!';
            if(id === 'course') errorMsg.textContent = 'Course is required!';
            if(id === 'end_date') errorMsg.textContent = 'End Date is required!';

            input.parentElement.appendChild(errorMsg);
        }
    });

    if (!isValid) e.preventDefault();
});

// Clear errors on input/change
fields.forEach(id => {
    const input = document.getElementById(id);
    const eventType = input.type === 'date' ? 'change' : 'input';
    input.addEventListener(eventType, function() {
        if (this.value.trim() !== '') {
            this.classList.remove('error');
            const oldError = this.parentElement.querySelector('.error-message');
            if (oldError) oldError.remove();
        }
    });
});
</script>