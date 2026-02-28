<!-- ==================== CERTIFICATE COMPONENT ==================== -->
<div class="certificate-free-wrapper">
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
                                <?php echo ! empty($displayCourse) ? htmlspecialchars($displayCourse) : 'FREE HTML CSS TAILWIND' ?>
                            </div>

                            <div class="cert-free-granted">
                                Granted: <span id="cert_time"><?php echo ! empty($displayDate) ? htmlspecialchars($displayDate) : 'Auguest 15,2025' ?></span>
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
                               <font color="black">ID: </font> <span id="cert_id_val"><?php echo ! empty($displayId) ? htmlspecialchars($displayId) : (!empty($generatedId) ? htmlspecialchars($generatedId) : '0987654321 ETEC') ?></span>
                            </div>

                        </div>
                    </div>
                </div>

    </div>



</div>

<script>
// Generate unique certificate ID (PHP-style)
function generateCertificateId() {
    const num = String(Math.floor(Math.random() * 9000000000) + 1000000000).substring(0, 10);
    return num + ' ETEC';
}

// Print Certificate Function - A4 Landscape
document.addEventListener('DOMContentLoaded', function() {
    const printBtn = document.getElementById('btnPrintCertificate');
    if (!printBtn) {
        console.log('Print button not found, skipping print initialization');
        return;
    }

    printBtn.addEventListener('click', function(e) {
        console.log('Print button clicked');
        
        // Check if validation passes (call the validation function from form)
        if (typeof window.validateBeforePrint === 'function') {
            const isValid = window.validateBeforePrint();
            if (!isValid) {
                console.log('Validation failed, preventing print');
                e.preventDefault();
                return;
            }
        }

        // Generate a new unique ID for this certificate
        const certIdElement = document.getElementById('cert_id_val');
        if (certIdElement) {
            certIdElement.textContent = generateCertificateId();
        }

        // Get certificate element
        const certificate = document.getElementById('printable-certificate-free');
        if (!certificate) {
            console.error('Certificate element not found');
            alert('Certificate element not found');
            return;
        }

        // Get all dynamic values from the preview
        const studentName = document.getElementById('cert_student_name').textContent;
        const courseName = document.getElementById('cert_course').textContent;
        const grantedDate = document.getElementById('cert_time').textContent;
        const certId = document.getElementById('cert_id_val').textContent;

        console.log('Certificate data:', { studentName, courseName, grantedDate, certId });

        // Get base URL
        const baseUrl = window.location.origin + '/';
        const cssUrl = baseUrl + 'assets/css/certificate-class-free.css';
        const logoUrl = baseUrl + 'assets/Images/logo.png';
        const borderUrl = baseUrl + 'assets/Images/border.png';

        console.log('Base URL:', baseUrl);

        // Build the print document - Using SAME structure and classes as screen display
        const printContent = `
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Certificate of Completion</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
<link href="${cssUrl}" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

@page {
    size: A4 landscape;
    margin: 0;
}

html, body {
    margin: 0;
    padding: 0;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
}

/* ===== A4 PAGE LAYOUT - Same as screen ===== */
.certificate-free-wrapper {
    width: 297mm;
    height: 210mm;
    overflow: hidden;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    box-shadow: none;
}

.certificate-free-wrap {
    width: 297mm;
    height: 210mm;
}

.certificate-free {
    background: #fff;
    width: 100%;
    height: 100%;
}

/* ===== BORDERS - Same as screen ===== */
.cert-free-outer-border {
    border: 20px solid #20215f;
    padding: 4px;
    height: 100%;
}

.cert-free-inner-border {
    border: 10px solid #5e5f65b2;
    padding: 35px 40px 30px;
    background: #fff;
    height: calc(100% - 8px);
}

/* ===== HEADER - Same as screen ===== */
.cert-free-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.cert-free-header-left {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cert-free-header-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.cert-free-logo-box {
    width: 132px;
    height: 132px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    overflow: hidden;
}

.cert-free-logo-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.cert-free-motto {
    font-size: .84rem;
    color: #333;
    margin-top: 4px;
    font-weight: bold;
    font-family: Arial, sans-serif;
}

.cert-free-kingdom {
    text-align: center;
    font-size: .90rem;
    font-weight: 700;
    letter-spacing: .22em;
    color: #222;
    line-height: 2;
    text-transform: uppercase;
    font-family: 'Courier New', monospace;
    white-space: nowrap;
}

.cert-free-kingdom img {
    display: block;
    max-width: 132px;
    height: auto;
    margin: 8px auto 0;
    object-fit: contain;
}

/* ===== TITLE - Same as screen ===== */
.cert-free-title {
    text-align: center;
    font-family: 'Dancing Script', 'Brush Script MT', cursive;
    font-size: 4.2rem;
    font-weight: 900;
    color: #20215f;
    margin: 8px 0 18px;
    white-space: nowrap;
}

/* ===== CONTENT - Same as screen ===== */
.cert-free-certify {
    text-align: center;
    font-size: 1.2rem;
    color: #20215f;
    letter-spacing: .12em;
    margin-bottom: 16px;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    white-space: nowrap;
}

.cert-free-student-name {
    text-align: center;
    font-size: 1.74rem;
    font-weight: 700;
    color: #111;
    letter-spacing: .1em;
    text-transform: uppercase;
    margin-bottom: 20px;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    white-space: nowrap;
}

.cert-free-desc {
    text-align: center;
    font-size: 1.2rem;
    color: #20215f;
    line-height: 2;
    margin-bottom: 14px;
    font-family: Arial, sans-serif;
    letter-spacing: .01em;
    white-space: nowrap;
}

.cert-free-course {
    text-align: center;
    font-size: 1.8rem;
    color: black;
    letter-spacing: .07em;
    margin-bottom: 20px;
    font-family: 'Courier New', monospace;
    font-weight: 900;
    white-space: nowrap;
}

.cert-free-granted {
    text-align: center;
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d2e81;
    letter-spacing: .05em;
    margin-bottom: 36px;
    font-family: Arial, sans-serif;
    white-space: nowrap;
}

/* ===== FOOTER - Same as screen ===== */
.cert-free-footer {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding-top: 8px;
    position: relative;
}

.cert-free-signature {
    text-align: right;
    margin-left: auto;
}

.cert-free-sig-line {
    height: 1px;
    background: #cea324;
    width: 160px;
    margin-left: auto;
    margin-bottom: 4px;
}

.cert-free-sig-name {
    font-size: .936rem;
    font-weight: 900;
    color: #111;
    font-family: 'Courier New', monospace;
    letter-spacing: .05em;
    white-space: nowrap;
}

.cert-free-sig-role {
    font-size: .888rem;
    color: #333;
    font-family: 'Courier New', monospace;
    letter-spacing: .07em;
    white-space: nowrap;
}

.cert-free-id-bottom {
    text-align: center;
    font-size: .672rem;
    color: red;
    font-family: 'Courier New', monospace;
    letter-spacing: .04em;
    margin-top: 20px;
    white-space: nowrap;
}

</style>
</head>

<body>

<div class="certificate-free-wrapper">
    <div class="certificate-free-wrap">
        <div class="certificate-free">
            <div class="cert-free-outer-border">
                <div class="cert-free-inner-border">

                    <!-- Header: Logo Left, Kingdom Right -->
                    <div class="cert-free-header">
                        <div class="cert-free-header-left">
                            <div class="cert-free-logo-box">
                                <img src="${logoUrl}" alt="">
                            </div>
                            <div class="cert-free-motto">"Build your IT Skill"</div>
                        </div>
                        <div class="cert-free-header-right">
                            <div class="cert-free-kingdom">
                                <div>KINGDOM OF CAMBODIA</div>
                                <div>NATION&nbsp; RELIGION &nbsp;KING</div>
                                <img src="${borderUrl}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="cert-free-title">
                        Certificate of Completion
                    </div>

                    <div class="cert-free-certify">
                        This is to certify that
                    </div>

                    <div class="cert-free-student-name">
                        ${studentName}
                    </div>

                    <div class="cert-free-desc">
                        has successfully completed all requirements for completion of the  <br> I.T Training Courses in
                    </div>

                    <div class="cert-free-course">
                        ${courseName}
                    </div>

                    <div class="cert-free-granted">
                        Granted: ${grantedDate}
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
                       <font color="black">ID: </font> ${certId}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 800);
}
<\/script>

</body>
</html>
`;

        // Create a new window for printing
        const printWindow = window.open('', '_blank', 'width=1000,height=700,scrollbars=yes');

        if (!printWindow) {
            // Popup blocked - try alternative method
            alert('Popup blocked! Please allow popups for this site to print the certificate.\n\nAlternatively, you can:\n1. Press Ctrl+P (or Cmd+P on Mac)\n2. Select "Save as PDF" as the destination');
            return;
        }

        printWindow.document.write(printContent);
        printWindow.document.close();

        // Focus the print window
        printWindow.focus();
        console.log('Print window opened');
    });
});
</script>
