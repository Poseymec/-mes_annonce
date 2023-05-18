  
<h2> annonces</h2>



<?php foreach($annonces as $annonce):?>

    <p><a href="annonces/lire/<?=$annonce->id?>"><?=$annonce->titre ?></a></p>
    
<?php endforeach ?>