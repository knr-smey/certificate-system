<div class="container py-2">

    <h2 class="mb-4 text-center fw-bold">តារាង សញ្ញាបត្រធម្មតា</h2>

    <div id="tables_container"></div>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
const perPage = 9;
let allData = [];
let categoryPages = {};
let currentType = 'normal';

$(document).ready(function() {
    loadClasses();
});

function loadClasses() {
    const container = $('#tables_container');
    container.html('<p>កំពុងផ្ទុក...</p>');

    const urlParams = new URLSearchParams(window.location.search);
    currentType = urlParams.get('type') || 'normal';
    const type = currentType;

    $.ajax({
        url: "<?= base_url('api/classes') ?>",
        method: "GET",
        data: { type: type },
        dataType: "json",
        success: function(result) {
            if (!result.data || result.data.length === 0) {
                container.html('<p class="text-center text-muted">មិនមានទិន្នន័យ</p>');
                return;
            }

            allData = result.data;

            const categories = [...new Set(allData.map(item => item.category))];
            categories.forEach(cat => categoryPages[cat] = 1);

            renderAllTables();
        },
        error: function() {
            container.html('<p class="text-center text-danger">Server Error</p>');
        }
    });
}

function renderAllTables() {
    const container = $('#tables_container');
    container.html('');

    const categories = Object.keys(categoryPages);

    categories.forEach(categoryName => {
        const page = categoryPages[categoryName];
        const categoryData = allData.filter(item => item.category === categoryName);

        const start = (page - 1) * perPage;
        const end = start + perPage;
        const pageData = categoryData.slice(start, end);

        const rows = pageData.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${item.teacher_name ?? '<span class="badge bg-danger">គ្មានគ្រូ</span>'}</td>
                <td>${item.course ?? '-'}</td>
                <td>${item.time ?? '-'}</td>
                <td>${item.class_type_name ?? '-'}</td>
                <td>
                    <a href="<?= base_url('certificate/students') ?>?class_id=${item.id}&course=${encodeURIComponent(item.course)}&teacher=${encodeURIComponent(item.teacher_name ?? 'គ្មានគ្រូ')}&time=${encodeURIComponent(item.time ?? '-')}&type=${encodeURIComponent(currentType)}"
                        class="btn btn-primary  btn-sm">
                        <i class="bi bi-people-fill me-1"></i>មើលសិស្ស
                    </a>
                </td>
            </tr>
        `).join('');

        // Pagination
        const totalPages = Math.ceil(categoryData.length / perPage);
        let buttons = '';
        if (page > 1) {
            buttons += `<button class="btn btn-outline-primary me-2" onclick="changeCategoryPage('${categoryName}', ${page-1})">មុន</button>`;
        }
        for (let i = 1; i <= totalPages; i++) {
            buttons += `<button class="btn ${i===page?'btn-primary':'btn-outline-primary'} me-2" onclick="changeCategoryPage('${categoryName}', ${i})">${i}</button>`;
        }
        if (page < totalPages) {
            buttons += `<button class="btn btn-outline-primary" onclick="changeCategoryPage('${categoryName}', ${page+1})">បន្ទាប់</button>`;
        }

        container.append(`
            <div class="card mb-4 shadow-sm">
                <div class="card-header fs-5 bg-category text-white fw-semibold">
                    ប្រភេទវគ្គសិក្សារ ${categoryName}
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle mb-2">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>គ្រូបង្រៀន</th>
                                <th>មុខវិជ្ជា</th>
                                <th>ម៉ោង</th>
                                <th>Class Type</th>
                                <th>សិស្ស</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-2">
                        ${buttons}
                    </div>
                </div>
            </div>
        `);
    });
}

function changeCategoryPage(categoryName, page) {
    categoryPages[categoryName] = page;
    renderAllTables();
}
</script>
