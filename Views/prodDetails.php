<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=3");
}

include_once '../Controllers/ProductController.php';

function cat($id){
    include_once '../Controllers/CategoryController.php';
    if ($id != -1) {
        $ctrls = new CategoryController();
        $res = $ctrls->selectById($id);
        $infos = $res->fetch_assoc();
        $nomCat = $infos['nom'];
        return $nomCat;
    }  
}

if (isset($_GET['prod'])) {
    $options = "";

    $ctrl = new ProductController();
    $resultado = $ctrl->selectById($_GET['prod']);

    if (!$resultado) {
        die("Error: no se pudo realizar la consulta");
    }

    $info = $resultado->fetch_assoc();

    $id_prod = $info['id_producte'];
    $id_categoria = $info['id_categoria'];
    $preu_inicial = $info['preu_inicial'];
    $nom = $info['nom'];
    $desc_llarga = $info['desc_llarga'];
    $url_foto = $info['url_foto'];
    $nomCat=cat($id_categoria);

    
} else {
    header("Location: http://localhost/sce/Views/index.php?view=error&error=1");
}
?>

<div id="formulari">
    <form method="post" action="../Controllers/Command.php?controller=ProductController&action=update" name="update">
        <fieldset>
            <input type="hidden" name="id_prod" id="id_prod" value="<?php echo $id_prod ?>">
            <?php echo "Id: " . $id_prod ?>
            <br>
             <?php echo LABEL_CATEGORIES . ": "?>
            <?php echo $nomCat?>
            <select name="cat">
                <option value="<?php echo $id_categoria ?>"><?php echo LABEL_CHOOSE_NEW ?></option>
                <option value="-1"><?php echo LABEL_NONE ?></option>
                <?php echo $options ?>
            </select>
            <br>
            <?php echo LABEL_NAME ?>: <input type="text" placeholder="<?php echo LABEL_NAME ?>" value="<?php echo $nom ?>" name="nom" id="nom"/>
            <br>
            <?php echo LABEL_DESCRIPTION ?>:<br> <textarea style="width: 100%; height: 30%; " name="desc_llarga"><?php echo $desc_llarga; ?></textarea>
            <br>
            <?php echo LABEL_PREU_INI ?><input type="text" placeholder="<?php echo LABEL_PREU_INI ?>" value="<?php echo $preu_inicial ?>" name="preu_ini" id="preu_ini"/>
            <br>
            <br>
            <?php echo LABEL_FOTO ?>:<br> <textarea style="width: 100%;" name="url_foto"><?php echo $url_foto; ?></textarea>
            <br>
            <input type="submit" value="<?php echo LABEL_UPDATE ?>"/>
            <br>
        </fieldset>
    </form>
</div>