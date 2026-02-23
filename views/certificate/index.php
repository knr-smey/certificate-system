<?php if ($type === 'normal' || $type === 'free' || $type === 'scholarship'): ?>

    <?php if ($title === 'Certificate'): ?>
        <?php include './views/components/tables/table_teacher.php'; ?>
    <?php elseif ($title === 'liststudents'): ?>
        <?php include './views/components/tables/table_student.php'; ?>
    <?php elseif ($title === 'Certificate'): ?>
        <?php include './views/certificate/scholarship.php'; ?>
    <?php endif; ?>
    <p>Invalid certificate type.</p>
    
<?php endif; ?>