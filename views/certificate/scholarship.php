<div class="container py-2">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md-5">
            <h2 class="fw-bold mb-0">តារាង សញ្ញាបត្រអាហារូបករណ៍</h2>
        </div>

        <div class="col-12 col-md-7 d-flex justify-content-md-end justify-content-start gap-2">
            <select id="categoryFilter" class="form-select" style="max-width: 400px;">
                <option value="all">ទាំងអស់</option>
            </select>

            <button class="btn-top-action text-nowrap" id="btnPrintCertificate">
                <i class="bi bi-award-fill me-0"></i>
                ​ បង្កើតវិញ្ញាបនបត្រ
            </button>
        </div>
    </div>

    <div id="tables_container"></div>
</div>

<!-- ==================== PRINT CERTIFICATE MODAL ==================== -->
<div class="modal fade" id="certTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content cert-modal-content">

            <!-- Header (hidden when printing) -->
            <div class="modal-header cert-modal-header no-print">
                <h5 class="modal-title text-white">
                    <i class="bi bi-printer-fill me-2 "></i>បោះពុម្ពសញ្ញាបត្រ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body: two panels (left edit panel is hidden when printing) -->
            <div class="modal-body p-0 d-flex no-print" style="min-height:500px;">

                <!-- LEFT: Edit Form (hidden when printing) -->
                <div class="cert-edit-panel">
                    <div class="cert-edit-title">
                        <i class="bi bi-pencil-square me-2"></i>កែប្រែព័ត៌មាន
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">ឈ្មោះសិស្ស</label>
                        <input type="text" id="edit_student_name" class="cert-field-input" placeholder="Student name...">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">មុខវិជ្ជា / Course</label>
                        <input type="text" id="edit_course" class="cert-field-input" placeholder="Course name...">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">ថ្ងៃខែឆ្នាំ / Granted Date</label>
                        <input type="text" id="edit_granted" class="cert-field-input" placeholder="e.g. February 17, 2026">
                    </div>

                    <div class="cert-field-group">
                        <label class="cert-field-label">លេខ ID</label>
                        <div class="d-flex gap-2">
                            <input type="text" id="edit_id" class="cert-field-input" placeholder="Auto-generated">
                            <button class="cert-btn-regen" onclick="regenId()" title="Generate new ID" type="button">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Saved courses from localStorage -->
                    <div class="cert-saved-section" id="saved_courses_wrap" style="display:none">
                        <div class="cert-saved-title">
                            <i class="bi bi-bookmark-fill me-1"></i>Course រក្សាទុក
                        </div>
                        <div id="saved_courses_list"></div>
                    </div>
                </div>

                <!-- RIGHT: Certificate Preview (this is what prints) -->
                <div class="cert-preview-panel" id="printable-certificate">
                    <div class="cert-preview-label">PREVIEW</div>
                    <div id="certificate_content">
                        <div class="certificate-wrap">
                            <div class="certificate">
                                <div class="cert-outer-border">
                                    <div class="cert-inner-border">
                                        <div class="cert-kingdom">
                                            <div>KINGDOM OF CAMBODIA</div>
                                            <div>NATION&nbsp; RELIGION &nbsp;KING</div>
                                        </div>
                                        <div class="cert-logo-area">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCRerloxG_go8MpvD_FYvHwpSWb7580gwmBw&s"
                                                alt="Logo" class="cert-logo-img"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                            <div class="cert-logo-fallback">
                                                <i class="bi bi-award-fill"></i>
                                            </div>
                                        </div>
                                        <div class="cert-school-kh">មជ្ឈមណ្ឌលវិស្វកម្មបច្ចេកវិទ្យា និង<span class=" text-black">អេឡិចត្រូនិក</span></div>
                                        <div class="cert-school-en"><span class=" text-black">Engineering</span> of Technology and Electronic Center</div>
                                        <div class="cert-title">Certificate of Completion</div>
                                        <div class="cert-certify">This is to certify that</div>
                                        <h1 class="cert-student-name" id="cert_student_name">—</h1>
                                        <div class="cert-desc">
                                            has successfully completed all requirements for completion<br>
                                            of the Computer Training Courses in
                                        </div>
                                        <h4 class="cert-course" id="cert_course">—</h4>
                                        <div class="cert-granted">Granted: <span id="cert_time">—</span></div>
                                        <div class="cert-footer">
                                            <div class="cert-id">ID : <span id="cert_id_val">—</span></div>
                                            <div class="cert-signature">
                                                <div class="cert-sig-line"></div>
                                                <div class="cert-sig-name text-center" id="cert_sign_teacher">Mr. Heng Pheakna</div>
                                                <div class="cert-sig-role text-center">Director</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer buttons (hidden when printing) -->
            <div class="modal-footer cert-modal-footer no-print">
                <button type="button" class="btn-cert-close" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>បិទ
                </button>
                <button type="button" class="btn-cert-save" onclick="saveCourseTeacher()">
                    <i class="bi bi-bookmark-fill me-2"></i>រក្សាទុក Course
                </button>
                <button type="button" class="btn-cert-print text-white" onclick="printCertificateTeacher()">
                    <i class="bi bi-printer-fill me-2"></i>បោះពុម្ព
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const perPage = 10;
    let allData = [];
    let categoryPages = {};

    $(document).ready(function() {
        loadClasses();

        // Trigger render when filter changes
        $('#categoryFilter').on('change', function() {
            renderAllTables();
        });
        // Live preview updates
        $('#edit_student_name').on('input', function() {
            $('#cert_student_name').text($(this).val() || '—');
        });
        $('#edit_course').on('input', function() {
            $('#cert_course').text($(this).val() || '—');
        });
        $('#edit_granted').on('input', function() {
            $('#cert_time').text($(this).val() || '—');
        });
        $('#edit_id').on('input', function() {
            $('#cert_id_val').text($(this).val() || '—');
        });

        // Open modal with defaults
        $('#btnPrintCertificate').on('click', function() {
            $('#certTeacherModal').modal('show');
        });
    });

    function loadClasses() {
        const container = $('#tables_container');
        container.html('<p class="text-center mt-4">Loading...</p>');

        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get('type') || 'scholarship';

         $.ajax({
            url: "<?= base_url('api/classes') ?>",
            method: "GET",
            data: {
                type: type
            },
            dataType: "json",
            success: function(result) {
                if (!result.data || result.data.length === 0) {
                    container.html(`
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-exclamation-circle display-4"></i>
                        <p class="mt-3">មិនមានវគ្គសិក្សាទេ</p>
                    </div>
                `);
                    return;
                }

                allData = result.data;

                const categories = [...new Set(allData.map(item => item.category))];
                categories.forEach(cat => categoryPages[cat] = 1);

                const select = $('#categoryFilter');
                select.find('option:not([value="all"])').remove();
                categories.forEach(cat => select.append(`<option value="${cat}">${cat}</option>`));

                renderAllTables();
            },
            error: function() {
                container.html(`
                <div class="text-center py-5 text-danger">
                    <i class="bi bi-x-circle display-4"></i>
                    <p class="mt-3">Server Error មិនអាចទាញទិន្នន័យបាន</p>
                </div>
            `);
            }
        });
    }

    // ==================== OPEN CERT MODAL ====================
    function openCertModal(studentName, course, teacher) {
        $('#edit_student_name').val(studentName || '').trigger('input');
        $('#edit_course').val(course || '').trigger('input');
        $('#cert_sign_teacher').text(teacher || 'Mr. Heng Pheakna');
        $('#edit_granted').val(new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        })).trigger('input');
        regenId();
        $('#certModal').modal('show');
    }

     // ==================== REGENERATE ID ====================
    function regenId() {
        const newId = Math.floor(Math.random() * 10000);
        $('#edit_id').val(newId).trigger('input');
    }

     // ==================== SAVE / LOAD / DELETE COURSES ====================
    function saveCourseTeacher() {
        const course = $('#edit_course').val().trim();
        if (!course) {
            alert('សូមបញ្ចូលឈ្មោះ Course សិន!');
            return;
        }
        let saved = JSON.parse(localStorage.getItem('saved_courses') || '[]');
        if (!saved.includes(course)) {
            saved.push(course);
            localStorage.setItem('saved_courses', JSON.stringify(saved));
        }
        loadSavedCourses();
    }

    function applySavedCourse(c) {
        $('#edit_course').val(c).trigger('input');
    }

    function deleteSavedCourse(c) {
        let saved = JSON.parse(localStorage.getItem('saved_courses') || '[]');
        localStorage.setItem('saved_courses', JSON.stringify(saved.filter(x => x !== c)));
        loadSavedCourses();
    }

    // ==================== PRINT ====================
    function printCertificateTeacher() {
        window.print();
    }

    function renderAllTables() {
        const container = $('#tables_container');
        container.html('');

        const selectedCategory = $('#categoryFilter').val();
        let categoriesToRender = Object.keys(categoryPages);

        if (selectedCategory !== 'all') {
            categoriesToRender = [selectedCategory];
        }

        categoriesToRender.forEach(categoryName => {
            const page = categoryPages[categoryName];
            const categoryData = allData.filter(item => item.category === categoryName);

            const start = (page - 1) * perPage;
            const end = start + perPage;
            const pageData = categoryData.slice(start, end);

            // Map exact 6 columns from the new images
            const rows = pageData.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${item.teacher_name ?? '<span class="badge bg-danger">No Teacher</span>'}</td>
                <td>${item.course ?? '-'}</td>
                <td>${item.time ?? '-'}</td>
                <td>${item.category ?? '-'}</td>
                <td>
                    <a href="<?= base_url('certificate/students') ?>?class_id=${item.id}&course=${encodeURIComponent(item.course)}&teacher=${encodeURIComponent(item.teacher_name ?? 'គ្មានគ្រូ')}&time=${encodeURIComponent(item.time ?? '-')}" class="btn-view-student">
                        <i class="fas fa-users"></i> មើលសិស្ស
                    </a>
                </td>
            </tr>
        `).join('');

            // Pagination buttons
            const totalPages = Math.ceil(categoryData.length / perPage);
            let buttons = '';

            if (page > 1) {
                buttons += `<button class="page-btn" onclick="changeCategoryPage('${categoryName}', ${page-1})">ត្រឡប់</button>`;
            }
            for (let i = 1; i <= totalPages; i++) {
                let activeClass = i === page ? 'active' : '';
                buttons += `<button class="page-btn ${activeClass}" onclick="changeCategoryPage('${categoryName}', ${i})">${i}</button>`;
            }
            if (page < totalPages) {
                buttons += `<button class="page-btn" onclick="changeCategoryPage('${categoryName}', ${page+1})">បន្ទាប់</button>`;
            }

            if (pageData.length > 0) {
                container.append(`
                <div class="custom-card">
                    <div class="custom-card-header">
                        ប្រភេទវគ្គសិក្សារ ${categoryName}
                    </div>
                    
                    <div class="custom-card-body">
                        <div class="table-responsive">
                            <table class="table custom-table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 8%;">ID</th>
                                        <th style="width: 17%;">គ្រូបង្រៀន</th>
                                        <th style="width: 20%;">មុខវិជ្ជា</th>
                                        <th style="width: 20%;">ម៉ោង</th>
                                        <th style="width: 20%;">ប្រភេទ ថ្នាក់</th>
                                        <th style="width: 15%;">សកម្មភាព</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${rows}
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="custom-pagination">
                            ${buttons}
                        </div>
                    </div>
                </div>
            `);
            }
        });
    }

    function changeCategoryPage(categoryName, page) {
        categoryPages[categoryName] = page;
        renderAllTables();
    }
</script>