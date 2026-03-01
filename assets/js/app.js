/**
 * Certificate System - App JS
 * MVC API Structure Example
 */

console.log("Certificate System JS Loaded");

// ==================== CERTIFICATE FUNCTIONS ====================

/**
 * Live Preview - Update certificate as user types
 * This connects the edit form fields to the certificate preview
 */
document.addEventListener('DOMContentLoaded', function() {
    // Student Name - Live Preview
    const studentNameInput = document.getElementById('edit_student_name');
    const certStudentName = document.getElementById('cert_student_name');
    if (studentNameInput && certStudentName) {
        studentNameInput.addEventListener('input', function() {
            certStudentName.textContent = this.value || 'PHEAROM RATHA';
        });
    }

    // Course - Live Preview
    const courseInput = document.getElementById('edit_course');
    const certCourse = document.getElementById('cert_course');
    if (courseInput && certCourse) {
        courseInput.addEventListener('input', function() {
            certCourse.textContent = this.value || 'FREE HTML CSS TAILWIND';
        });
    }

    // Granted Date - Live Preview
    const grantedInput = document.getElementById('edit_granted');
    const certTime = document.getElementById('cert_time');
    if (grantedInput && certTime) {
        grantedInput.addEventListener('input', function() {
            certTime.textContent = this.value || 'Auguest 15,2025';
        });
    }

    // Certificate ID - Live Preview
    const idInput = document.getElementById('edit_id');
    const certId = document.getElementById('cert_id_val');
    if (idInput && certId) {
        idInput.addEventListener('input', function() {
            certId.textContent = this.value || '0987654';
        });
    }
});

/**
 * Regenerate Certificate ID
 * Generates a random 7-digit ID
 */
function regenId() {
    const idInput = document.getElementById('edit_id');
    const certId = document.getElementById('cert_id_val');
    
    if (idInput && certId) {
        // Generate random 7-digit ID
        const newId = Math.floor(1000000 + Math.random() * 9000000).toString();
        idInput.value = newId;
        certId.textContent = newId;
    }
}

/**
 * Print Certificate
 * Opens print dialog for the certificate
 */
function printCertificate() {
    console.log('Print button clicked');
    
    const certificate = document.getElementById('printable-certificate-free');
    if (!certificate) {
        console.error('Certificate element not found');
        alert('Certificate element not found');
        return;
    }

    // Get the base URL - try multiple approaches
    let baseUrl = window.location.origin + '/';
    // If we're in a subdirectory, try to detect it
    const pathParts = window.location.pathname.split('/').filter(p => p && p !== 'index.php');
    if (pathParts.length > 0) {
        // Remove the last part (current page) to get base path
        pathParts.pop();
        if (pathParts.length > 0) {
            baseUrl = window.location.origin + '/' + pathParts.join('/') + '/';
        }
    }
    console.log('Base URL:', baseUrl);
    
    const cssUrl = baseUrl + 'assets/css/certificate-class-free.css';
    const logoUrl = baseUrl + 'assets/Images/logo.png';
    const borderUrl = baseUrl + 'assets/Images/border.png';

    // Get the certificate HTML and replace relative URLs with absolute
    let certContent = certificate.innerHTML;
    certContent = certContent.replace(/src="assets\//g, 'src="' + baseUrl + 'assets/');
    certContent = certContent.replace(/src='assets\//g, "src='" + baseUrl + 'assets/');

    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'width=900,height=700');
    
    if (!printWindow) {
        alert('Please allow popups to print the certificate');
        return;
    }

    // Build the print document with proper CSS reference
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Certificate of Completion</title>
            <link rel="stylesheet" href="${cssUrl}">
            <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                @page {
                    size: A4 landscape;
                    margin: 0;
                    scale: 100%;
                }
                @media print {
                    body { 
                        margin: 0; 
                        padding: 0; 
                        width: 297mm;
                        height: 220mm;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    .certificate-free-wrap { 
                        margin: 0; 
                        padding: 0; 
                        width: 100% !important;
                        max-width: 100% !important;
                    }
                    .cert-free-preview-panel { 
                        padding: 0; 
                        width: 297mm !important;
                        height: 220mm !important;
                    }
                    .cert-free-outer-border {
                        width: 100% !important;
                    }
                }
                @media screen {
                    body {
                        background: #ccc;
                        padding: 20px;
                    }
                    .cert-free-preview-panel {
                        background: white;
                        box-shadow: 0 0 20px rgba(0,0,0,0.3);
                        max-width: 297mm;
                        margin: 0 auto;
                    }
                }
            </style>
        </head>
        <body>
            <div class="cert-free-preview-panel" id="printable-certificate-free">
                ${certContent}
            </div>
            <script>
                window.onload = function() {
                    // Wait for fonts and CSS to load
                    document.fonts.ready.then(function() {
                        console.log('Fonts loaded, ready to print');
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    }).catch(function() {
                        // If fonts fail, still print
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    });
                };
            <\/script>
        </body>
        </html>
    `);

    printWindow.document.close();
    console.log('Print window opened');
}

/**
 * Initialize certificate with student data
 * @param {Object} studentData - Student information
 */
function initCertificateWithData(studentData) {
    if (studentData.name) {
        const studentNameInput = document.getElementById('edit_student_name');
        const certStudentName = document.getElementById('cert_student_name');
        if (studentNameInput) studentNameInput.value = studentData.name;
        if (certStudentName) certStudentName.textContent = studentData.name;
    }
    
    if (studentData.course) {
        const courseInput = document.getElementById('edit_course');
        const certCourse = document.getElementById('cert_course');
        if (courseInput) courseInput.value = studentData.course;
        if (certCourse) certCourse.textContent = studentData.course;
    }
    
    if (studentData.granted_date) {
        const grantedInput = document.getElementById('edit_granted');
        const certTime = document.getElementById('cert_time');
        if (grantedInput) grantedInput.value = studentData.granted_date;
        if (certTime) certTime.textContent = studentData.granted_date;
    }
    
    if (studentData.certificate_id) {
        const idInput = document.getElementById('edit_id');
        const certId = document.getElementById('cert_id_val');
        if (idInput) idInput.value = studentData.certificate_id;
        if (certId) certId.textContent = studentData.certificate_id;
    }
}

// ==================== API FUNCTIONS ====================

/**
 * Fetch Classes via API
 * @param {string} type - 'normal', 'free', or 'scholarship'
 * @param {string} course - optional course filter
 */
async function fetchClasses(type = 'normal', course = '') {
  try {
    const url = new URL('/api/classes', window.location.origin);
    url.searchParams.append('type', type);
    if (course) url.searchParams.append('course', course);

    const response = await fetch(url);
    const result = await response.json();

    if (!result.ok) {
      console.error('API Error:', result.error);
      return [];
    }

    console.log('Classes:', result.data);
    return result.data;
  } catch (error) {
    console.error('Fetch error:', error);
    return [];
  }
}

/**
 * Fetch Students by Class
 * @param {number} classId - The class ID
 */
async function fetchStudents(classId) {
  if (!classId || classId <= 0) {
    console.error('Invalid classId');
    return [];
  }

  try {
    const url = new URL('/api/students', window.location.origin);
    url.searchParams.append('class_id', classId);

    const response = await fetch(url);
    const result = await response.json();

    if (!result.ok) {
      console.error('API Error:', result.error);
      return [];
    }

    console.log('Students:', result.data);
    return result.data;
  } catch (error) {
    console.error('Fetch error:', error);
    return [];
  }
}

// Example Usage:
// fetchClasses('normal').then(classes => console.log(classes));
// fetchStudents(1).then(students => console.log(students));
