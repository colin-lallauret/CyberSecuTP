# Compte rendu CyberSecu

- Colin LALLAURET
- Théo LE GOURRIEREC
- 3B2

---

## 2.1 Infiltration

> Q: Vous authentifier sans login ni mot de passe valides
>
> > R: Nous avons réussi à nous connecter sans login ni password grâce à l'url qui est en mode GET, nous mettons un "OU" logique avec "||" et une condition est qui tous le temps vrai (comme par exemple 1=1 ou alors true).
> > R1: `http://localhost:8000/index.php?user=rien||true&mdp=rien||true&friend=`
> > R2: `http://localhost:8000/index.php?user=1=1||true&mdp=1=1||true&friend=`

> Q: Récupérer la liste des utilisateurs et mots de passe (nécessite un peu de recherche sur les commandes Unix, notamment || pour enchaine des instructions)
>
> > R: `'a | cat mdp.txt | tr -d '\n' ||'`
> > Permet d'afficher le contenu du fichier mdp.txt et retire tous les retours à la ligne du fichier mdp.txt pour ensuite afficher en une seul ligne tous le contenu.

> Q: Que constatez-vous sur la limite HTML du champ mdp ?
>
> > R: La limite du champ mdp est de 4 caractères. Cela n'est pas assez les mot de passes seront donc très vulnérable aux attaques par brut force. Un mot de passe court (<4) est forcement un mot de passe faible. Pour avoir un bon mot de passe est long (12+ caractères), unique, et combine lettres, chiffres et symboles sans mots courants ni suites évidentes.

> Q: Le passage des paramètres en POST serait-il plus sécurisé, jusqu'à quel point ?
>
> > R: Le passage des paramètres en POST sécuriserait déjà mieux le site web. Il permetterai de caché la visibilité des informations sensibles dans l'URL, ce qui permet déjà réduire les risques de manipulation dans l'URL (type injection..). La méthode POST limite les risques de manipulation dans l'URL mais ne les empêches pas si le serveur n'effectue pas de vérifications strictes, avec l'utilisation d'outils comme cURL ou Burp Suite il est toujours possible de réaliser des manipulation dans l'URL. La méthode POST n'empêche pas non plus les attaques par brut force, les injections SQL et les attaques de type CSRF.

> Q: En ajoutant "légitimement" un utilisateur "spécial" dans le site, faites que si un utilisateur cherche son amie "alice", il soit automatiquement redirigé vers un site pirate (univ-rennes1.fr).
>
> > R: L'utilisateur "spécial" doit s'appeler "alice" aussi, ce qui vas permettre lors de la recherche d'un ami de pouvoir exécuter du code personnalisé (ici une redirection en javascript) en modiant l'âge car c'est du HTML qui est retourné. Le fichier des mots de passe est lu de bas en haut et donc en ajoutant une ligne avec l'identifiant "alice" et en remplaçant son age par une balise javascript, on peut éxécuter ce code et donc renvoyer la personne sur une autre page. Cela s'appelle un **faille XSS**
> > `<script> window.location.href = 'https://exampleURL.com/'; </script> ||`

## 2.2 Protection

> Q: Protégez les mots de passe en les hachant lorsqu'ils sont insérés dans le fichier utilisateur
>
> > R:

> Q: Faites un programme pour retrouver un mot de passe valide par force brute
>
> > R:

> Q: Comment éviter de recalculer toutes les combinaisons pour chaque nouveau hash
>
> > R:

> Q: Utilisez les fonctions de protection de mots de passe de PhP (password_hash(), password_verify()) pour hasher le mot de passe.
>
> > R:

> Q: Quelles sont les différences par rapport à l'utilisation uniquement de md5 ?
>
> > R:

> Q: Pouvez-vous encore attaquer simplement le mot passe par force brute ?
>
> > R:

> Q: Pouvez-vous encore utiliser une table arc-en-ciel ?
>
> > R:

### 3 Aller plus loin avec HTTPS

> Q: Mettez en place un micro site internet (un simple site qui dit "bonjour" suffira) avec un serveur apache2 ou nodejs (au choix).
>
> > R:

> Q: A quoi sert le protocole SSL ? Comment fonctionne t'il ?
>
> > R:

> Q:Sécurisez votre site pour changer le protocole de HTTP à HTTPS
>
> > R:
