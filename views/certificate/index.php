<?php if ($type === 'normal' || $type === 'free'): ?>

    <?php if ($title === 'Certificate'): ?>
        <?php include './views/components/tables/table_teacher.php'; ?>
    <?php elseif ($title === 'liststudents'): ?>
        <?php include './views/components/tables/table_student.php'; ?>
    <?php endif; ?>

<?php else: ?>
    <p>Invalid certificate type.</p>
<?php endif; ?>