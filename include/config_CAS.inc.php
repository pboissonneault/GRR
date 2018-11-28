<?php
/*
Ce fichier permet de configurer la r�cup�ration dans GRR
d'attributs LDAP des utilisateurs envoy�s par le serveur CAS
Lire attentivement la documentation avant de modifier ce fichier
*/

/*
On ne peut pas invoquer directement la fonction "phpCAS::getAttribute()"
car elle n'est pas impl�ment�e dans "CAS/CAS.php"
Dans cette biblioth�que, il n'y a que "phpCAS::getAttributes()" qui soit d�finie, contrairement � ce qui se passe avec "CAS/CAS/client.php".
*/
function getAttribute($key)
{
    global $PHPCAS_CLIENT, $PHPCAS_AUTH_CHECK_CALL;
    if (!is_object($PHPCAS_CLIENT))
    {
        phpCAS :: error('this method should not be called before ' . __CLASS__ . '::client() or ' . __CLASS__ . '::proxy()');
    }
    if (!$PHPCAS_AUTH_CHECK_CALL['done'])
    {
        phpCAS :: error('this method should only be called after ' . __CLASS__ . '::forceAuthentication() or ' . __CLASS__ . '::isAuthenticated()');
    }
    if (!$PHPCAS_AUTH_CHECK_CALL['result'])
    {
        phpCAS :: error('authentication was checked (by ' . $PHPCAS_AUTH_CHECK_CALL['method'] . '() at ' . $PHPCAS_AUTH_CHECK_CALL['file'] . ':' . $PHPCAS_AUTH_CHECK_CALL['line'] . ') but the method returned FALSE');
    }
    return $PHPCAS_CLIENT->getAttribute($key);
}

/*
 R�cup�ration des diff�rents attributs de l'annuaire LDAP envoy�s par le serveur CAS
 Explication de la premi�re ligne :
 phpCAS::getAttribute('user_nom_ldap') est la variable envoy� par CAS
 La fonction recuperer_nom() permet de traiter cette variable pour r�cup�rer la valeur utilis�e dans GRR
 Le r�sultat est alors stock� dans $user_nom

 Il en va de m�me des autres variables ci-dessous
 Vous pouvez personnaliser les fonctions de traitements des attributs LDAP envoy�s par le serveur CAS
 en modifiant le code des fonctions ci-dessous.
*/
$user_nom = recuperer_nom(phpCAS::getAttribute('sn'));
$user_prenom = recuperer_prenom(phpCAS::getAttribute('givenname'));
$user_language = recuperer_language(phpCAS::getAttribute('user_language_ldap'));
$user_code_fonction = recuperer_code_fonction(phpCAS::getAttribute('user_code_fonction_ldap'));
$user_libelle_fonction = recuperer_libelle_fonction(phpCAS::getAttribute('title')).' / '.phpCAS::getAttribute('ou');
$user_mail = recuperer_mail(phpCAS::getAttribute('mail'));
$user_default_style = "default";

/*
 Fonction permettant de r�cup�rer le nom dans le champ LDAP $user_nom
*/
function recuperer_nom($user_nom)
{
    # Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP
    return $user_nom;
}

/*
 Fonction permettant de r�cup�rer le pr�nom dans le champ LDAP $user_prenom
*/
function recuperer_prenom($user_prenom)
{
//Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP
    return $user_prenom;
}

/*
 Fonction permettant de r�cup�rer la langue � partir de l'attribut $user_language de l'annuaire LDAP
 Exemple (Cas de l'ENT Esco-Portail) :
 -------------------------------------
 function recuperer_language($user_language) {
	$res = substr($user_language, 0, 2);
	if (strcasecmp($res, "fr") == 0) {
		$lang = "fr";
	}
	else if (strcasecmp($res, "en") == 0) {
		$lang = "en";
	}
	else if (strcasecmp($res, "de") == 0) {
		$lang = "de";
	}
	else if (strcasecmp($res, "it") == 0) {
		$lang = "it";
	}
	else if (strcasecmp($res, "es") == 0) {
		$lang = "es";
	}
	else {
		$lang = "fr";
	}
	return $lang;
 }
*/
function recuperer_language($user_language)
{
//Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP (voir exemple ci-dessous)
    return $user_language;
}

/*
 Fonction permettant de r�cup�rer le code de la fonction dans le champ LDAP $user_code_fonction
 Exemple (Cas de l'ENT Esco-Portail) :
 -------------------------------------
 R�cup�ration du code de la fonction dans le champ LDAP multivalu� ENTPersonFonctions

 function recuperer_code_fonction($user_code_fonction) {
	$tab = explode ("$", $user_code_fonction);
	  return $tab[1];
 }
*/
function recuperer_code_fonction($user_code_fonction)
{
//Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP (voir exemple ci-dessous)
    return $user_code_fonction;
}


/*
 Fonction permettant de r�cup�rer le libell� de la fonction dans le champ LDAP $user_libelle_fonction
 Exemple (Cas de l'ENT Esco-Portail) :
 -------------------------------------
 R�cup�ration du libell� de la fonction dans le champ LDAP multivalu� ENTPersonFonctions

 function recuperer_libelle_fonction($user_libelle_fonction) {
	$tab = explode ("$", $user_libelle_fonction);
	  return $tab[2];
 }
*/

function recuperer_libelle_fonction($user_libelle_fonction)
{
//Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP (voir exemple ci-dessous)
    return $user_libelle_fonction;
}

/*
 Fonction permettant de r�cup�rer le mail dans le champ LDAP $user_mail
*/
function recuperer_mail($user_mail)
{
//Le cas �ch�ant, remplacez la ligne suivante par le code PHP ad�quat, correspondant � votre annuaire LDAP
    return $user_mail;
}
?>
