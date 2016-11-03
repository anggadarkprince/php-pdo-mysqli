<!doctype html>
<html>
<head>
    <title>Manage User</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php
    $action = isset($_GET['action']) ? $_GET['action'] : 'create';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    require_once 'application/User.php';
    $user = new User();
    if ($id != '') {
        require_once 'application/UserModel.php';
        $userModel = new UserModel();
        $user = $userModel->selectById($id);
    }
    ?>
    <h3><?= ucwords($action) ?> User</h3>

    <?php if (isset($_GET['action']) && isset($_GET['status'])) { ?>

        <div class="alert alert-<?= $_GET['status'] ?>">
            <?= ucfirst($_GET['action']) ?> user <?= $_GET['status'] ?>
        </div>

    <?php } ?>

    <form action="request/user.php?action=<?= $action ?>" method="post">
        <?php if($action == 'edit'){ ?>
            <input type="hidden" value="<?=$id?>" name="id">
        <?php } ?>
        <div class="control">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name"
                   value="<?= $user->getFirstName() ?>"
                   placeholder="Put your first name" required maxlength="50">
        </div>
        <div class="control">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name"
                   value="<?= $user->getLastName() ?>"
                   placeholder="Family or last name" required maxlength="80">
        </div>
        <div class="control">
            <label for="username">Username</label>
            <input type="text" name="username" id="username"
                   value="<?= $user->getUsername() ?>"
                   placeholder="Unique username" required maxlength="25">
        </div>
        <div class="control">
            <label for="password">Password <?= $action == 'edit' ? '(Put new password to update)' : '' ?></label>
            <input type="password" name="password" id="password"
                   value=""
                   placeholder="Account password" <?= $action == 'create' ? 'require' : '' ?> maxlength="40">
        </div>
        <button type="submit" class="button">Save User</button>
    </form>
</div>
</body>
</html>