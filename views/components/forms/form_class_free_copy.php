<div class="form-card">
    <!-- <div class="form-card-header">
        <div class="form-card-icon">
            <i class="bi bi-award-fill"></i>
        </div>
        <div>
            <div class="form-card-title">ទម្រង់ស្នើរសុំសញ្ញាប័ត្រ</div>
            <div class="form-card-subtitle">Certificate Request Form</div>
        </div>
    </div> -->

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
                <button type="button" id="printBtn" class="submit-btn">
                    Print
                </button>
            </div>
        </div>
    </form>
</div>
<!-- ================= CERTIFICATE PREVIEW ================= -->
<div class="certificate-preview">
    <div class="certificate-box">

        <div class="cert-header">
            <div>ETEC Center</div>
            <div>
                KINGDOM OF CAMBODIA <br>
                Nation · Religion · King
            </div>
        </div>

        <h2>Certificate of Completion</h2>

        <p>This is to certify that</p>

        <h1 id="preview_name">STUDENT NAME</h1>

        <p>has successfully completed the training course in</p>

        <h3 id="preview_course">COURSE NAME</h3>

        <p>Granted on <span id="preview_date">DATE</span></p>

        <div class="signature">
            _________________________ <br>
            Director
        </div>

    </div>
</div>

<!-- ================= TEMP CSS (FOR TESTING) ================= -->
<style>
.certificate-preview {
    margin-top: 0px;
    display: flex;
    justify-content: center;
}

.certificate-box {
    width: 900px;
    padding: 50px;
    background: #fff;
    /* border: 12px solid #0b2a63; */
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-align: center;
    font-family: 'Georgia', serif;
}

.cert-header {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    margin-bottom: 30px;
}

.certificate-box h2 {
    font-size: 32px;
    color: #0b2a63;
    margin-bottom: 20px;
}

.certificate-box h1 {
    font-size: 38px;
    margin: 20px 0;
    color: #0b2a63;
}

.certificate-box h3 {
    font-size: 24px;
    margin: 15px 0;
}

.signature {
    margin-top: 60px;
}
@media print {

    @page {
        size: A4 landscape;
        margin: 0;
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    body * {
        visibility: hidden;
    }

    .certificate-preview,
    .certificate-preview * {
        visibility: visible;
    }

    .certificate-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .certificate-box {
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        padding: 20mm;
        border: 8px solid #0b2a63;
        box-shadow: none;
    }
}
</style>

<script>
const nameInputPreview = document.getElementById('student_name');
const courseInputPreview = document.getElementById('course');
const dateInputPreview = document.getElementById('end_date');

const previewName = document.getElementById('preview_name');
const previewCourse = document.getElementById('preview_course');
const previewDate = document.getElementById('preview_date');

nameInputPreview.addEventListener('keyup', function() {
    previewName.textContent = this.value || "STUDENT NAME";
});

courseInputPreview.addEventListener('keyup', function() {
    previewCourse.textContent = this.value || "COURSE NAME";
});

dateInputPreview.addEventListener('change', function() {
    previewDate.textContent = this.value || "DATE";
});

// PRINT BUTTON
document.getElementById('printBtn').addEventListener('click', function () {

    const certificate = document.querySelector('.certificate-box').outerHTML;

    const printWindow = window.open('', '', 'width=1200,height=800');

    printWindow.document.write(`
        <html>
        <head>
            <title></title>
            <style>
                @page {
                    size: A4 landscape;
                    margin: 0;
                }

                html, body {
                    margin: 0;
                    padding: 0;
                }

                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    font-family: Georgia, serif;
                }

                .certificate-box {
                    width: 297mm;
                    height: 210mm;
                    padding: 20mm;
                    box-sizing: border-box;
                    border: 8px solid #0b2a63;
                    text-align: center;
                }

                .cert-header {
                    display: flex;
                    justify-content: space-between;
                    font-weight: bold;
                    margin-bottom: 30px;
                }

                h2 { font-size: 32px; color: #0b2a63; }
                h1 { font-size: 38px; margin: 20px 0; color: #0b2a63; }
                h3 { font-size: 24px; }
                .signature { margin-top: 60px; }

            </style>
        </head>
        <body>
            ${certificate}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close(); // Close the print window after printing
});

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
