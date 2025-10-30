<?php
include 'config.php';
session_start();
function ajouter_vue() :void{
    $fichier =  'data'. DIRECTORY_SEPARATOR . 'compteur';
    $fichier_journalier = $fichier. '-' .date('y-m-d');
    incrementer_compteur($fichier);
    incrementer_compteur($fichier_journalier);
}
function incrementer_compteur (string $fichier):void{
    $compteur = 1;
    if (file_exists($fichier)){
        // si le fichier existe on incrémente
        $compteur = (int)file_get_contents($fichier);
        $compteur++;
    }
        file_put_contents($fichier, $compteur);
}

function nombre_vues(): string{
    $fichier =  'data'. DIRECTORY_SEPARATOR . 'compteur';
   return file_get_contents($fichier);

}
?>


$reqArticles = $conn->query("SELECT * FROM products");
                while($produit = $reqArticles->fetch()){
                    $image = $produit['image_01'];
                    ?>