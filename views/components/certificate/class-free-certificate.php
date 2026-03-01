<!-- ==================== CERTIFICATE COMPONENT ==================== -->
<div class="certificate-free-wrapper certificate-preview">
    <div class="certificate-free-wrap" id="printable-certificate-free">
        <div class="certificate-free">
            <div class="cert-free-outer-border">
                <div class="cert-free-inner-border">

                    <!-- Header: Logo Left, Kingdom Right -->
                    <div class="cert-free-header">
                        <div class="cert-free-header-left">
                            <div class="cert-free-logo-box">
                                <img src="assets/Images/logo.png" alt="">
                            </div>
                            <div class="cert-free-motto">"Build your IT Skill"</div>
                        </div>
                        <div class="cert-free-header-right">
                            <div class="cert-free-kingdom">
                                <div>KINGDOM OF CAMBODIA</div>
                                <div>NATION&nbsp; RELIGION &nbsp;KING</div>
                                <img src="assets/Images/border.png" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="cert-free-title">
                        Certificate of Completion
                    </div>

                    <div class="cert-free-certify">
                        This is to certify that
                    </div>

                    <div class="cert-free-student-name" id="cert_student_name">
                      <?php echo ! empty($displayName) ? htmlspecialchars($displayName) : 'PHEAROM RATHA' ?>
                    </div>

                    <div class="cert-free-desc">
                        has successfully completed all requirements for completion of the  <br> I.T Training Courses in
                    </div>

                    <div class="cert-free-course" id="cert_course">
                        <?php echo ! empty($displayCourse) ? htmlspecialchars($displayCourse) : '' ?>
                    </div>

                    <div class="cert-free-granted">
                        Granted: <span id="cert_time"><?php echo ! empty($displayDate) ? htmlspecialchars($displayDate) : '' ?></span>
                    </div>

                    <div class="cert-free-footer">
                        <div class="cert-free-signature">
                            <div class="cert-free-sig-line"></div>
                            <div class="cert-free-sig-name">
                                Mr. Heng Pheakna
                            </div>
                            <div class="cert-free-sig-role">
                                Director
                            </div>
                        </div>
                    </div>

                    <div class="cert-free-id-bottom">
                       <font color="black">ID:</font> <span id="cert_id_val"><?php echo ! empty($generatedId) ? htmlspecialchars($generatedId) : '' ?></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

// Format date function
function formatCertDate(dateString) {
    if (!dateString) return '';
    const selectedDate = new Date(dateString);
    if (isNaN(selectedDate.getTime())) return '';

    const selectedDay = selectedDate.getDate();
    const cutoffDay = 10;

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
    const certificateDay = 15;

    return `${monthName} ${certificateDay},${year}`;
}

// Load saved data from localStorage on page load
function loadSavedData() {
    try {
        // Load course from localStorage
        const savedCourse = localStorage.getItem('certificate_course');
        const certCourse = document.getElementById('cert_course');
        if (savedCourse && certCourse) {
            certCourse.textContent = savedCourse.toUpperCase();
        }

        // Load end_date from localStorage
        const savedEndDate = localStorage.getItem('certificate_end_date');
        const certTime = document.getElementById('cert_time');
        if (savedEndDate && certTime) {
            certTime.textContent = formatCertDate(savedEndDate);
        }
    } catch(e) {
        console.error('Error loading saved data:', e);
    }
}

// Generate a unique certificate ID - matches PHP generateCertificateId() format
function generateCertificateId() {
    const year = new Date().getFullYear();
    const random4 = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    return year + random4 + 'ETEC';
}

// Common function to prepare certificate for print/PDF
function prepareCertificate() {
    // Generate a new unique ID using the correct format
    const certIdElement = document.getElementById('cert_id_val');
    if (certIdElement) {
        certIdElement.textContent = generateCertificateId();
    }
    return true;
}

// Direct print handler function
function handlePrint() {
    console.log('handlePrint called');

    if (typeof window.validateBeforePrint === 'function') {
        const isValid = window.validateBeforePrint();
        if (!isValid) {
            console.log('Validation failed');
            return;
        }
    }

    prepareCertificate();

    // Remove preview class for print to ensure correct scale
    const certWrapper = document.querySelector('.certificate-free-wrapper');
    if (certWrapper) {
        certWrapper.classList.remove('certificate-preview');
    }

    // Reset any zoom/transform that browser may apply
    document.body.style.zoom = '1';
    document.documentElement.style.zoom = '1';
    document.body.style.transform = 'none';
    document.body.style.margin = '0';
    document.body.style.padding = '0';

    setTimeout(() => {
        window.print();
        // Restore preview class after print dialog closes
        if (certWrapper) {
            certWrapper.classList.add('certificate-preview');
        }
        document.body.style.zoom = '';
        document.documentElement.style.zoom = '';
    }, 150);

    console.log('Print dialog opened');
}
// Save as PDF handler function
function handleSavePDF() {
    console.log('handleSavePDF called');

    // Check if validation passes
    if (typeof window.validateBeforePrint === 'function') {
        const isValid = window.validateBeforePrint();
        if (!isValid) {
            console.log('Validation failed');
            return;
        }
    }

    // Prepare certificate
    prepareCertificate();

    // Remove preview class for PDF to ensure correct scale
    const certWrapper = document.querySelector('.certificate-free-wrapper');
    if (certWrapper) {
        certWrapper.classList.remove('certificate-preview');
    }

    // Print directly - user can choose Save as PDF in print dialog
    setTimeout(() => {
        window.print();
        // Restore preview class after print dialog closes
        if (certWrapper) {
            certWrapper.classList.add('certificate-preview');
        }
    }, 150);

    console.log('Print dialog opened for PDF save');
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    loadSavedData();

    // Set up event listeners
    const printBtn = document.getElementById('btnPrintCertificate');
    if (printBtn) {
        printBtn.addEventListener('click', handlePrint);
    }

    const pdfBtn = document.getElementById('btnSavePDF');
    if (pdfBtn) {
        pdfBtn.addEventListener('click', handleSavePDF);
    }
});
</script>
