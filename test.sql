SELECT p.titre, d.quantite, d.prix, c.montant, DATE_FORMAT(c.date_enregistrement, '%d/%m/%Y à %H:%i:%s') as date_fr, c.etat
FROM details_commande d
LEFT JOIN commande c ON c.id_commande = d.id_commande
LEFT JOIN produit p ON d.id_produit = p.id_produit;


SELECT c.id_commande, p.titre, d.quantite, d.prix
FROM details_commande d
LEFT JOIN produit p ON d.id_produit = p.id_produit
LEFT JOIN commande c ON c.id_commande = d.id_commande
WHERE d.id_commande = 10;

SELECT id_produit, titre, stock FROM produit WHERE id_produit IN 
    (SELECT id_produit FROM details_commande WHERE id_commande = 12);
        

SELECT quantite 
FROM details_commande 
WHERE id_commande = 10 AND id_produit = 9;