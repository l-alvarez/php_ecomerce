<?php
if (!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/CategoryController.php';

if (isset($_GET['cat'])) {
    $options = "";

    $ctrl = new CategoryController();
    $resultado = $ctrl->selectById($_GET['cat']);

    if (!$resultado) {
        die("Error: no se pudo realizar la consulta");
    }

    $info = $resultado->fetch_assoc();

    $id = $info['id_categoria'];
    $name = $info['nom'];
    $desc = $info['descripcio'];
    $padre = (double) $info['id_categoria_pare'];

    $all = $ctrl->selectAll();

    while ($next = mysql_fetch_assoc($all)) {
        if ($next['id_categoria'] != $id) {
            $options .='<option value="' . $next['id_categoria'] . '">' . $next['nom'] . '</option>';
        }
    }

    if ($padre != -1) {
        $fetch = $ctrl->selectById($padre);
        $father = $fetch->fetch_assoc();
        $father_name = $father['nom'];
        $father_id = $father['id_categoria'];
    } else {
        $father_name = LABEL_NONE;
        $father_id = -1;
    }
} else {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=1");
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=CategoryController&action=update" name="update">
        <fieldset>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <?php echo "Id: " . $id ?>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" placeholder="<?php echo LABEL_NAME ?>" value="<?php echo $name ?>" name="name" id="name"/>
            <br>
            <?php echo LABEL_DESCRIPTION ?>:<br> <textarea name="desc"><?php echo $desc; ?></textarea>
            <br>
            <?php echo LABEL_FATHER . ": " . $father_name ?>
            <br>
            <select name="padre">
                <option value="<?php echo $father_id ?>"><?php echo LABEL_CHOOSE_NEW ?></option>
                <option value="-1"><?php echo LABEL_NONE ?></option>
                <?php echo $options ?>
            </select>
            <br>
            <input type="submit" value="<?php echo LABEL_UPDATE ?>"/>
            <br>
        </fieldset>
    </form>
</div>