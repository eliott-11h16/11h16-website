<?php require_once 'auth.php';

$projects = getAllProjectsAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    verifyCsrf();
    if ($_POST['action'] === 'reorder' && isset($_POST['ids'])) {
        reorderProjects($_POST['ids']);
        header('Location: index.php?msg=reordered');
        exit;
    }
    if ($_POST['action'] === 'toggle_site' && isset($_POST['id'])) {
        toggleShowOnSite((int)$_POST['id']);
        header('Location: index.php?msg=toggled');
        exit;
    }
}

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects — 11H16 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wdth,wght@8..144,25..151,100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-wrap">
        <aside class="admin-sidebar">
            <h2>11H16</h2>
            <nav class="admin-nav">
                <a href="index.php" class="active">Projects</a>
                <a href="content-edit.php">Site Content</a>
                <div class="nav-sep"></div>
                <a href="../" target="_blank">View Site</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>
        <main class="admin-main">
            <div class="admin-header">
                <h1>Projects (<?= count($projects) ?>)</h1>
                <a href="project-edit.php" class="btn btn-primary">+ New Project</a>
            </div>

            <?php if ($msg === 'saved'): ?><div class="alert alert-success">Project saved.</div><?php endif; ?>
            <?php if ($msg === 'deleted'): ?><div class="alert alert-success">Project deleted.</div><?php endif; ?>
            <?php if ($msg === 'reordered'): ?><div class="alert alert-success">Order updated.</div><?php endif; ?>
            <?php if ($msg === 'toggled'): ?><div class="alert alert-success">Visibility updated.</div><?php endif; ?>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th style="width:30px"></th>
                            <th style="width:70px">Thumb</th>
                            <th>Name</th>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Site</th>
                            <th>Hero</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="projectList">
                        <?php foreach ($projects as $p): ?>
                        <tr data-id="<?= $p['id'] ?>" style="<?= $p['show_on_site'] ? '' : 'opacity:0.5;' ?>">
                            <td><span class="drag-handle">&#9776;</span></td>
                            <td>
                                <?php if ($p['thumbnail']): ?>
                                    <img src="../<?= e($p['thumbnail']) ?>" class="thumb-sm" alt="">
                                <?php else: ?>
                                    <div class="thumb-sm"></div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= e($p['name']) ?></strong></td>
                            <td><?= e($p['client']) ?></td>
                            <td><?= e($p['type']) ?></td>
                            <td>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                                    <input type="hidden" name="action" value="toggle_site">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn btn-sm <?= $p['show_on_site'] ? 'btn-primary' : 'btn-secondary' ?>" title="<?= $p['show_on_site'] ? 'Visible sur le site' : 'Masqué du site' ?>">
                                        <?= $p['show_on_site'] ? '&#10003; Site' : '&#10005; Off' ?>
                                    </button>
                                </form>
                            </td>
                            <td><?= $p['is_hero'] ? '&#9733;' : '' ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="project-edit.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="project-delete.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this project?')">Del</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <form id="reorderForm" method="POST" style="display:none">
                <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
                <input type="hidden" name="action" value="reorder">
            </form>
        </main>
    </div>
    <script src="admin.js"></script>
</body>
</html>
