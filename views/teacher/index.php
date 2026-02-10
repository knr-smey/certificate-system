<h1 class="mb-4">👨‍🏫 Teacher</h1>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($teachers)): ?>
      <tr>
        <td colspan="4" class="text-center text-danger">
          No teacher found
        </td>
      </tr>
    <?php else: ?>
      <?php foreach ($teachers as $i => $t): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= e($t['teacher_name']) ?></td>
          <td><?= e($t['email']) ?></td>
          <td><?= e($t['phone']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
