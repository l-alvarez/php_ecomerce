<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/SubastaController.php';

if (isset($_GET['sub'])) {
    $options = "";

    $ctrl = new SubastaController();
    $resultado = $ctrl->selectById($_GET['sub']);

    if (!$resultado) {
        die("Error: no se pudo realizar la consulta");
    }

    $info = $resultado->fetch_assoc();

    $id_subhasta = $info['id_subhasta'];
    $id_prod=$info["id_producte"];
    $id_max_postor=$info["id_max_postor"];
    $data_limit = $info['data_limit'];
    $hora_limit = $info['hora_limit'];
    $estat = $info['estat'];
} else {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=1");
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=SubastaController&action=update" name="update">
        <fieldset>
            <input type="hidden" name="id_sub" id="id_sub" value="<?php echo $id_subhasta?>">
            <?php echo "Id: " . $id_subhasta ?>
            <br>
             <?php echo LABEL_PRODUCTES ?><input type="text" placeholder="<?php echo LABEL_PRODUCTES ?>" value="<?php echo $id_prod ?>" name="id_prod" id="id_prod"/>
            <br>
            <?php echo LABEL_USERNAME?>: <input type="text" placeholder="<?php echo LABEL_USERNAME ?>" value="<?php echo $id_max_postor ?>" name="id_max_postor" id="id_max_postor"/>
            <br>
            <?php echo LABEL_DATA_LIMIT?>: <input type="date" placeholder="<?php echo LABEL_DATA_LIMIT ?>" value="<?php echo $data_limit ?>" name="data_limit" id="data_limit"/>
            <br>
            <?php echo LABEL_TIME ?><input type="time" placeholder="<?php echo LABEL_TIME ?>" value="<?php echo $hora_limit ?>" name="hora_limit" id="hora_limit"/>
            <br>
           <?php echo LABEL_ESTAT?>: <input type="text" placeholder="<?php echo LABEL_ESTAT ?>" value="<?php echo $estat ?>" name="estat" id="estat"/>
            <br>
            <input type="submit" value="<?php echo LABEL_UPDATE ?>"/>
            <br>
        </fieldset>
    </form>
</div>