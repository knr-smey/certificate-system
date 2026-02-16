<div class="container py-2">

    <h2 class="mb-4 text-center fw-bold">តារាង សញ្ញាបត្រធម្មតា</h2>

    <div id="tables_container"></div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
const perPage = 10;
let allData = [];
let categoryPages = {}; // track current page per category

$(document).ready(function() {
    loadClasses();
});

function loadClasses() {
    const container = $('#tables_container');
    container.html('<p>Loading...</p>');

    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type') || 'normal';

    $.ajax({
        url: "<?= base_url('api/classes') ?>",
        method: "GET",
        data: { type: type },
        dataType: "json",
        success: function(result) {

            if (!result.data || result.data.length === 0) {
                container.html('<p>No data found</p>');
                return;
            }

            allData = result.data;

            // get unique categories
            const categories = [...new Set(allData.map(item => item.category))];
            categories.forEach(cat => categoryPages[cat] = 1);

            renderAllTables();
        },
        error: function() {
            container.html('<p>Server Error</p>');
        }
    });
}

// Render all category tables
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
                <td>${item.teacher_name ?? '<span class="badge bg-danger">No Teacher</span>'}</td>
                <td>${item.course ?? '-'}</td>
                <td>${item.time ?? '-'}</td>
            </tr>
        `).join('');

        // Pagination buttons per category
        const totalPages = Math.ceil(categoryData.length / perPage);
        let buttons = '';
        if (page > 1) {
            buttons += `<button class="btn btn-outline-primary me-2" onclick="changeCategoryPage('${categoryName}', ${page-1})">Previous</button>`;
        }
        for (let i = 1; i <= totalPages; i++) {
            buttons += `<button class="btn ${i===page?'btn-primary':'btn-outline-primary'} me-2" onclick="changeCategoryPage('${categoryName}', ${i})">${i}</button>`;
        }
        if (page < totalPages) {
            buttons += `<button class="btn btn-outline-primary" onclick="changeCategoryPage('${categoryName}', ${page+1})">Next</button>`;
        }

        container.append(`
            <div class="card mb-4 shadow-sm">
                <div class="card-header fs-5 bg-primary text-white fw-semibold">
                    ${categoryName}
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle mb-2">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Teacher</th>
                                <th>Course</th>
                                <th>Time</th>
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

// Change page for a specific category
function changeCategoryPage(categoryName, page) {
    categoryPages[categoryName] = page;
    renderAllTables();
}
</script>
