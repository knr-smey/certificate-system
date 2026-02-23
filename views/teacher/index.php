<div class="container-fluid py-4 px-4">

    <!-- Header -->
    <div class="t-page-header mb-4">
        <div class="t-header-icon text-white">
            <i class="bi bi-person-video3"></i>
        </div>
        <div>
            <h1 class="t-page-title pb-2">គ្រូបង្រៀន</h1>
            <p class="t-page-sub">គ្រប់គ្រងគ្រូបង្រៀនរបស់អ្នក</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="t-card">
        <div class="t-card-header">
            <div class="d-flex align-items-center gap-3">
                <div class="t-header-icon-sm">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="t-card-title">បញ្ជីគ្រូបង្រៀន</div>
                    <div class="t-card-sub">Teacher List</div>
                </div>
            </div>
            <span class="t-count-badge">
                សរុប <?= empty($teachers) ? 0 : count($teachers) ?> នាក់
            </span>
        </div>

        <div class="table-responsive">
            <table class="t-table">
                <thead>
                    <tr>
                        <th style="width:60px">ល.រ</th>
                        <th>ឈ្មោះ</th>
                        <th>អ៊ីមែល</th>
                        <th>លេខទូរស័ព្ទ</th>
                        <th style="width:120px;text-align:center">ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($teachers)): ?>
                        <tr>
                            <td colspan="5" class="t-empty">
                                <i class="bi bi-inbox"></i>
                                <div class="t-empty-title">មិនមានគ្រូបង្រៀន</div>
                                <div class="t-empty-sub">សូមបន្ថែមគ្រូបង្រៀនដំបូងរបស់អ្នក</div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($teachers as $i => $t): ?>
                            <tr>
                                <td class="text-center text-white">
                                    <span class="t-row-no"><?= $i + 1 ?></span>
                                </td>
                                <td>
                                    <div class="t-teacher-name">
                                        <div class="t-avatar">
                                            <?= strtoupper(substr(e($t['teacher_name']), 0, 2)) ?>
                                        </div>
                                        <div>
                                            <div class="t-name-text"><?= e($t['teacher_name']) ?></div>
                                            <div class="t-name-sub">បង្រៀន</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:<?= e($t['email']) ?>" class="t-link-primary">
                                        <i class="bi bi-envelope-fill me-2"></i><?= e($t['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:<?= e($t['phone']) ?>" class="t-link-dark">
                                        <i class="bi bi-telephone-fill me-2 t-icon-primary"></i><?= e($t['phone']) ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="t-status-badge">
                                        <i class="bi bi-check-circle-fill me-1"></i>សកម្ម
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($teachers)): ?>
        <div class="t-card-footer">
            <i class="bi bi-info-circle me-1"></i>
            បង្ហាញ <?= count($teachers) ?> គ្រូបង្រៀន
        </div>
        <?php endif; ?>
    </div>

</div>

<style>
/* ── Page Header ─────────────────────────────── */
.t-page-header {
    display: flex; align-items: center; gap: 16px;
}
.t-header-icon {
    width: 56px; height: 56px; border-radius: 12px;
    background: var(--sidebar-bg);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: var(--sidebar-logo-icon);
    box-shadow: 0 4px 14px rgba(45,46,129,.25);
}
.t-page-title {
    font-size: 1.6rem; font-weight: 700;
    color: var(--app-primary); margin: 0;
}
.t-page-sub {
    font-size: .83rem; color: var(--app-text-muted); margin: 0;
}

/* ── Table Card ──────────────────────────────── */
.t-card {
    background: var(--app-card-bg);
    border-radius: 12px;
    border: 1px solid var(--app-card-border);
    box-shadow: 0 2px 12px rgba(45,46,129,.09);
    overflow: hidden;
}
.t-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 24px;
    background: var(--sidebar-bg);
    color: var(--sidebar-text-main);
}
.t-header-icon-sm {
    width: 40px; height: 40px; border-radius: 8px;
    background: var(--sidebar-logo-bg);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: var(--sidebar-logo-icon);
}
.t-card-title { font-weight: 700; font-size: .95rem; color: var(--sidebar-text-white); }
.t-card-sub   { font-size: .72rem; color: var(--sidebar-text-sub); }
.t-count-badge {
    background: var(--sidebar-active-bg);
    border: 1.5px solid var(--sidebar-border);
    color: var(--sidebar-text-white);
    padding: 5px 16px; border-radius: 6px;
    font-weight: 700; font-size: .85rem;
}

/* ── Table ───────────────────────────────────── */
.t-table { width: 100%; border-collapse: collapse; }
.t-table thead tr { background: #eeeef8; }
.t-table th {
    padding: 12px 16px;
    font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    color: var(--app-primary-dark);
    border-bottom: 2px solid var(--app-card-border);
    white-space: nowrap;
}
.t-table tbody tr {
    border-bottom: 1px solid #f0f0f8;
    transition: background .15s;
}
.t-table tbody tr:hover { background: #f5f5fc; }
.t-table tbody tr:last-child { border-bottom: none; }
.t-table td {
    padding: 13px 16px;
    font-size: .88rem; color: var(--app-text-main);
    vertical-align: middle;
}

/* ── Row Elements ────────────────────────────── */
.t-row-no {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    background: var(--sidebar-bg);
    color: var(--sidebar-text-white);
    font-weight: 700; font-size: .78rem;
}
.t-teacher-name { display: flex; align-items: center; gap: 12px; }
.t-avatar {
    width: 40px; height: 40px; border-radius: 10px;
    background: #eeeef8;
    display: flex; align-items: center; justify-content: center;
    color: var(--app-primary); font-weight: 700; font-size: .82rem;
    letter-spacing: .02em;
}
.t-name-text { font-weight: 600; color: var(--app-text-main); }
.t-name-sub  { font-size: .74rem; color: var(--app-text-muted); }

.t-link-primary {
    text-decoration: none; color: var(--app-primary);
    font-weight: 500; font-size: .86rem;
    transition: opacity .15s;
}
.t-link-primary:hover { opacity: .75; }

.t-link-dark {
    text-decoration: none; color: var(--app-text-main);
    font-weight: 500; font-size: .86rem;
}
.t-icon-primary { color: var(--app-primary); }

.t-status-badge {
    display: inline-flex; align-items: center;
    padding: 4px 12px; border-radius: 6px;
    background: #d1fae5; color: #065f46;
    font-size: .78rem; font-weight: 600;
}

/* ── Empty State ─────────────────────────────── */
.t-empty {
    text-align: center; padding: 56px 0;
    color: var(--app-text-muted);
}
.t-empty .bi-inbox {
    font-size: 2.8rem; display: block;
    color: var(--app-primary); opacity: .2; margin-bottom: 12px;
}
.t-empty-title { font-size: 1rem; font-weight: 600; margin-bottom: 4px; }
.t-empty-sub   { font-size: .83rem; }

/* ── Footer ──────────────────────────────────── */
.t-card-footer {
    padding: 12px 24px;
    background: var(--app-bg-color);
    border-top: 1px solid var(--app-card-border);
    font-size: .8rem; color: var(--app-text-muted);
}
</style>