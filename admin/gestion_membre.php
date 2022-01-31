<?php

require_once '../inc/init.inc.php';

if(isAdmin()){

    if(isset($_GET['action']) && ($_GET['action']) == 'modif' && isset($_GET['id'])){
        $statut = getStatutById($_GET['id']);
        if($statut == 0){
            sql("UPDATE membre SET statut = 1 WHERE id_membre = :id", array(
                'id' => $_GET['id']
            ));
            addMessage('Membre passé en administrateur','info');
        } else if ($statut == 1){
            sql("UPDATE membre SET statut = 0 WHERE id_membre = :id", array(
                'id' => $_GET['id']
            ));
            addMessage('Administrateur rétrogradé','info');
        }
    }

    if(isset($_GET['action']) && ($_GET['action']) == 'delete' && isset($_GET['id'])){
        sql("DELETE FROM membre WHERE id_membre = :id",array(
            'id' => $_GET['id']
        ));
        addMessage('Membre supprimé avec succès','info');
    }

$title = "Gestion Membre";

$data = getAllUser();
$fields = getUserFields();

require_once '../inc/haut.inc.php';?>

<div class="row text-center justify-content-center">
    <h2 class="text-center my-2">Gestion des membres</h2>
</div>
<div class="table-responsive">
    <table class="table table-bordered text-center my-4" style="table-layout:auto;">
        <thead>
            <tr>
                <?php foreach($fields as $index => $field):?>
                <th>

                    <?=($field['Field'])?>
                </th>
                <?php endforeach?>

                <th>User/Admin</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $dataUser):
        $dataUser['mdp'] = '⁇';
        $dataUser['statut'] == 0 ? $dataUser['statut'] = "User" : $dataUser['statut'] = "Admin";
        ?>

            <tr>
                <td class="align-middle"><?= implode('</td><td class="align-middle">',$dataUser)?></td>
                <?php if($dataUser['pseudo'] == 'Bobby') {
                ?>
                <td class="align-middle">Chef</td>
                <?php }else if($dataUser['statut'] == "User"){ ?>
                <td class="align-middle"><a style="text-decoration:none"
                        href="?action=modif&id=<?=  $dataUser['id_membre']  ?>">✅</a></td>
                <?php } else if ($dataUser['statut'] == "Admin") { ?>
                <td class="align-middle"><a style="text-decoration:none"
                        href="?action=modif&id=<?=  $dataUser['id_membre']  ?>">❌</a></td>
                <?php } ?>
                <?php if($dataUser['pseudo'] == 'Bobby') { ?>
                <td class="align-middle">⛔️</td>
                <?php } else { ?>
                <td class="align-middle"><a style="text-decoration:none"
                        href="?action=delete&id=<?=  $dataUser['id_membre']  ?>">🗑</a></td>
            </tr>
            <?php } ?>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php

} else {
    header('location:/site/');
}
require_once '../inc/bas.inc.php';