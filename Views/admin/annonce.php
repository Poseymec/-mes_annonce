<h2>liste des annonces</h2>

<?php if(!empty($_SESSION['message'])):?>
    <div class='alert alert-success' role="alert">
        <?php echo $_SESSION["message"] ;
        unset($_SESSION['message']); ?>
    </div>

    <?php endif; ?>
    <?php if(!empty($_SESSION['erreur'])):?>
    <div class='alert alert-danger' role="alert">
        <?php echo $_SESSION["erreur"] ;
        unset($_SESSION['erreur']); ?>
    </div>

    <?php endif; ?>

<table class="table table-striped">
    <thead>
        <th>ID</ht>
        <th>NOM</ht>
        <th>CONTENU</ht>
        <th>DATE DE CREATION</th>
        <th>ACTIF</ht>
        <th>ACTION</ht>
    </thead>
    <body>
        <?php foreach($annonces as $annonce):?>

            <tr>
                <td><?=$annonce->id?></td>
                <td><?=$annonce->titre?></td>
                <td><?=$annonce->description?></td>
                <td><?=$annonce->date_creation?></td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked<?=$annonce->id?>"<?=$annonce->actif? 'checked':''?> >
                        
                        <label class="form-check-label" for="flexSwitchCheckChecked<?=$annonce->id?>"></label>
                    </div>
                </td>
                <td>
                    <a href="/annonces/modifier/<?=$annonce->id?>" class="btn btn-warning">modifier</a>
                    <a href="/admin/supprimer/<?=$annonce->id?>"class="btn btn-danger">supprimer</a>
                </td>
            </tr>

        <?php endforeach ;?>
    </body>
</table>