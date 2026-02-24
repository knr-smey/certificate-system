<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container py-2">
    <h2 class="mb-4 text-center fw-bold">តារាង សញ្ញាបត្រអាហារូបករណ៍</h2>
    <div id="tables_container"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
const perPage = 10;
let allData = [];
let categoryPages = {}; 

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
                <td>
                    <button class="btn-custom-action">
                        <i class="fas fa-users"></i> មើលសិស្ស
                    </button>
                </td>
            </tr>
        `).join('');

        // Pagination buttons per category
        const totalPages = Math.ceil(categoryData.length / perPage);
        let buttons = '';
        
        if (page > 1) {
            buttons += `<button class="btn btn-outline-primary px-3 me-2" onclick="changeCategoryPage('${categoryName}', ${page-1})">ត្រឡប់</button>`;
        }
        for (let i = 1; i <= totalPages; i++) {
            let activeClass = i === page ? 'btn-primary' : 'btn-outline-primary';
            buttons += `<button class="btn ${activeClass} me-2" onclick="changeCategoryPage('${categoryName}', ${i})">${i}</button>`;
        }
        if (page < totalPages) {
            buttons += `<button class="btn btn-outline-primary px-3" onclick="changeCategoryPage('${categoryName}', ${page+1})">បន្ទាប់</button>`;
        }

        container.append(`
            <div class="scholarship-card mb-4 shadow-sm">
                <div class="scholarship-header fs-5">
                   ប្រភេទវគ្គសិក្សារ ${categoryName}
                </div>
                
                <div class="table-responsive p-3">
                    <table class="table scholarship-table text-center align-middle mb-0">
                        <thead class="scholarship-table-head">
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 20%;">គ្រូបង្រៀន</th>
                                <th style="width: 25%;">មុខវិជ្ជា</th>
                                <th style="width: 25%;">ម៉ោង</th>
                                <th style="width: 20%;">សិស្ស</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center pb-4 custom-pagination">
                    ${buttons}
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