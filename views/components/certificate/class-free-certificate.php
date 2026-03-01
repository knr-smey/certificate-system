<!-- ==================== CERTIFICATE COMPONENT ==================== -->
<!-- ADD id="class-free-cert" to the wrapper so JS can find it -->
<div class="certificate-free-wrapper certificate-preview" id="class-free-cert">
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

                    <div class="cert-free-student-name" id="cert_student_name_free">
                      <?php echo ! empty($displayName) ? htmlspecialchars($displayName) : 'PHEAROM RATHA' ?>
                    </div>

                    <div class="cert-free-desc">
                        has successfully completed all requirements for completion of the  <br> I.T Training Courses in
                    </div>

                    <div class="cert-free-course" id="cert_course_free">
                        <?php echo ! empty($displayCourse) ? htmlspecialchars($displayCourse) : '' ?>
                    </div>

                    <div class="cert-free-granted">
                        Granted: <span id="cert_time_free"><?php echo ! empty($displayDate) ? htmlspecialchars($displayDate) : '' ?></span>
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
                       <font color="black">ID:</font> <span id="cert_id_val_free"><?php echo ! empty($generatedId) ? htmlspecialchars($generatedId) : '' ?></span>
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
        const savedCourse = localStorage.getItem('certificate_course');
        const certCourse = document.getElementById('cert_course_free');
        if (savedCourse && certCourse) {
            certCourse.textContent = savedCourse.toUpperCase();
        }

        const savedEndDate = localStorage.getItem('certificate_end_date');
        const certTime = document.getElementById('cert_time_free');
        if (savedEndDate && certTime) {
            certTime.textContent = formatCertDate(savedEndDate);
        }
    } catch(e) {
        console.error('Error loading saved data:', e);
    }
}

// Generate a unique certificate ID
function generateCertificateId() {
    const year = new Date().getFullYear();
    const random4 = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    return year + random4 + 'ETEC';
}

// Prepare certificate before print
function prepareCertificate() {
    const certIdElement = document.getElementById('cert_id_val_free');
    if (certIdElement) {
        certIdElement.textContent = generateCertificateId();
    }
    return true;
}

// ─── Print using CSS isolation (cleaner approach) ───────────
function printOnlyFreeCert() {
    const certWrapper = document.getElementById('class-free-cert');
    if (!certWrapper) { window.print(); return; }

    // ✅ Create a temporary <style> tag that hides EVERYTHING except our cert
    const style = document.createElement('style');
    style.id = 'print-isolation-style';
    style.innerHTML = `
        @media print {
            body > * { display: none !important; }
            #class-free-cert { 
                display: block !important; 
                visibility: visible !important;
                position: fixed !important;
                top: 0 !important; left: 0 !important;
                width: 297mm !important;
                height: 210mm !important;
                margin: 0 !important;
                padding: 0 !important;
                z-index: 9999 !important;
            }
            #class-free-cert * { visibility: visible !important; }
            #class-free-cert.certificate-preview .certificate-free-wrap {
                transform: none !important;
            }
        }
    `;
    document.head.appendChild(style);

    // Remove preview scale
    certWrapper.classList.remove('certificate-preview');

    setTimeout(() => {
        window.print();
        // Cleanup after print
        const s = document.getElementById('print-isolation-style');
        if (s) s.remove();
        certWrapper.classList.add('certificate-preview');
    }, 200);
}
// Direct print handler
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

    setTimeout(() => {
        printOnlyFreeCert();
    }, 150);

    console.log('Print dialog opened');
}

// Save as PDF handler
function handleSavePDF() {
    console.log('handleSavePDF called');

    if (typeof window.validateBeforePrint === 'function') {
        const isValid = window.validateBeforePrint();
        if (!isValid) {
            console.log('Validation failed');
            return;
        }
    }

    prepareCertificate();

    setTimeout(() => {
        printOnlyFreeCert();
    }, 150);

    console.log('Print dialog opened for PDF save');
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    loadSavedData();

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