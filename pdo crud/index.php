<!doctype html>
<html>
<head>
    <title>User Management</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="clearfix">
        <div class="pull-left">
            <h3>User List</h3>
            <p>List of registered user member</p>
        </div>
        <a href="form.php?action=create" class="button pull-right" style="margin-top: 20px">
            Create new User
        </a>
        <div class="clearfix"></div>
    </div>

    <?php if (isset($_GET['action']) && isset($_GET['status'])) { ?>

        <div class="alert alert-<?= $_GET['status'] ?>">
            <?= ucfirst($_GET['action']) ?> user <?= $_GET['status'] ?>
        </div>

    <?php } ?>

    <?php
    include_once 'application/UserModel.php';

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : 'id';
    $method = isset($_GET['method']) ? $_GET['method'] : 'desc';

    $userModel = new UserModel();
    $users = $userModel->selectAll($page, $order, $method, $query);
    $no = ($page - 1) * 10;
    ?>

    <form class="filter" id="filter">
        <label>Search</label>
        <input type="text" placeholder="Search user" name="query" value="<?= $query ?>">
        <div class="pull-right">
            <label for="order">Sort By</label>
            <select name="order" id="order">
                <option value="id" <?= ($order == 'id') ? 'selected' : '' ?>>ID</option>
                <option value="first_name" <?= ($order == 'first_name') ? 'selected' : '' ?>>Name</option>
                <option value="username" <?= ($order == 'username') ? 'selected' : '' ?>>Username</option>
            </select>
            <select name="method" id="method">
                <option value="desc" <?= ($method == 'desc') ? 'selected' : '' ?>>Descending</option>
                <option value="asc" <?= ($method == 'asc') ? 'selected' : '' ?>>Ascending</option>
            </select>
        </div>
    </form>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th align="right">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>

            <tr>
                <td><?= ++$no ?></td>
                <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td align="right">
                    <a href="form.php?action=edit&id=<?= $user['id'] ?>" class="button">Edit</a>
                    <form action="request/user.php?action=delete" method="post">
                        <input type="hidden" value="<?= $user['id'] ?>" name="id">
                        <button type="submit" class="button red"
                                onclick="return confirm('Are you sure want to delete?')">Delete
                        </button>
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        Page :
        <?php
        // build params
        $query_string = $_SERVER['QUERY_STRING'];
        $params = explode('&', $query_string);
        for ($i = 0; $i < count($params); $i++) {
            $param = explode('=', $params[$i]);
            if ($param[0] == 'page') {
                array_splice($params, $i, 1);
                break;
            }
        }
        $base_query = implode('&', $params);
        if ($base_query != '') {
            $base_query .= '&';
        }

        // print pagination
        $totalData = $userModel->countData($page, $order, $method, $query);
        $totalPage = ceil($totalData / 10);
        for ($i = 1; $i <= $totalPage; $i++) { ?>
            <a href="index.php?<?= $base_query ?>page=<?= $i ?>"><?= $i ?></a>
        <?php } ?>
    </div>
</div>
<script>
    document.getElementById('order').onchange = function () {
        filter('order', this.value)
    }
    document.getElementById('method').onchange = function () {
        filter('method', this.value)
    }

    function filter(variable, value) {
        var queryString = "<?=$_SERVER['QUERY_STRING']?>";
        var params = queryString.split('&');
        for (var i = 0; i < params.length; i++) {
            var param = params[i].split('=');
            if (param[0] == variable) {
                param[1] = value;
                params[i] = param.join('=');
            }
        }
        queryString = params.join('&');
        document.getElementById('filter').submit();
    }
</script>
</body>
</html>