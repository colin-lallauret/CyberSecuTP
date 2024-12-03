# Compte rendu CyberSecu

- Colin LALLAURET
- Théo LE GOURRIEREC
- 3B2

---

## 2.1 Infiltration

> **Q: Vous authentifier sans login ni mot de passe valides**
>
> R: Nous avons réussi à nous connecter sans login ni password grâce à l'url qui est en mode GET, nous mettons un "OU" logique avec "||" et une condition est qui tous le temps vrai (comme par exemple 1=1 ou alors true).
> R1: `http://localhost:8000/index.php?user=rien||true&mdp=rien||true&friend=`
> R2: `http://localhost:8000/index.php?user=1=1||true&mdp=1=1||true&friend=`

> **Q: Récupérer la liste des utilisateurs et mots de passe (nécessite un peu de recherche sur les commandes Unix, notamment || pour enchaine des instructions)**
>
> R: `'a | cat mdp.txt | tr -d '\n' ||'`
> Permet d'afficher le contenu du fichier mdp.txt et retire tous les retours à la ligne du fichier mdp.txt pour ensuite afficher en une seul ligne tous le contenu.

> **Q: Que constatez-vous sur la limite HTML du champ mdp ?**
>
> R: La limite du champ mdp est de 4 caractères. Cela n'est pas assez les mot de passes seront donc très vulnérable aux attaques par brut force. Un mot de passe court (<4) est forcement un mot de passe faible. Pour avoir un bon mot de passe est long (12+ caractères), unique, et combine lettres, chiffres et symboles sans mots courants ni suites évidentes.

> **Q: Le passage des paramètres en POST serait-il plus sécurisé, jusqu'à quel point ?**
>
> R: Le passage des paramètres en POST sécuriserait déjà mieux le site web. Il permetterai de caché la visibilité des informations sensibles dans l'URL, ce qui permet déjà réduire les risques de manipulation dans l'URL (type injection..). La méthode POST limite les risques de manipulation dans l'URL mais ne les empêches pas si le serveur n'effectue pas de vérifications strictes, avec l'utilisation d'outils comme cURL ou Burp Suite il est toujours possible de réaliser des manipulation dans l'URL. La méthode POST n'empêche pas non plus les attaques par brut force, les injections SQL et les attaques de type CSRF.

> **Q: En ajoutant "légitimement" un utilisateur "spécial" dans le site, faites que si un utilisateur cherche son amie "alice", il soit automatiquement redirigé vers un site pirate (univ-rennes1.fr).**
>
> R: L'utilisateur "spécial" doit s'appeler "alice" aussi, ce qui vas permettre lors de la recherche d'un ami de pouvoir exécuter du code personnalisé (ici une redirection en javascript) en modiant l'âge car c'est du HTML qui est retourné. Le fichier des mots de passe est lu de bas en haut et donc en ajoutant une ligne avec l'identifiant "alice" et en remplaçant son age par une balise javascript, on peut éxécuter ce code et donc renvoyer la personne sur une autre page. Cela s'appelle un **faille XSS** > > `<script> window.location.href = 'https://exampleURL.com/'; </script> ||`

## 2.2 Protection

> **Q: Protégez les mots de passe en les hachant lorsqu'ils sont insérés dans le fichier utilisateur**
>
> R: Pour hashé les mot de passes lorsqu'ils sont insérés dans le fichier utilisateur, il suffit d'aller a la ligne 277 de index.php et d'ajouté md5() `$mdpADD = md5($_GET["mdpADD"]);`. Ensuite une fois le mot de passe hashé, il faut pouvoir comparer le hash avec le mot de passe que l'utilisateur vient d'entrer et pour faire cela il faut hashé le mot de passe entrer dans le champ pour ensuite le comparer au hash qui a été stocker. Pour réaliser cela il suffit d'aller à la ligne 198 et d'écrire : `$mdp = md5(_$GET["mdp"]);`

> **Q: Faites un programme pour retrouver un mot de passe valide par force brute**
>
> R: Pour cela on va crée un programme en python qui testera toutes les possibilités afin de retrouver le mot de passe correspondant. On définira le mot de passe à trouver au tout début du programme ainsi qu'une variable contenant les caractères de a à z, de 0 à 9 et de A à Z.

> **Q: Comment éviter de recalculer toutes les combinaisons pour chaque nouveau hash**
>
> R:

> **Q: Utilisez les fonctions de protection de mots de passe de PhP (password_hash(), password_verify()) pour hasher le mot de passe.**
>
> R: Voir le code indexHash.php 
> - Ligne 198 : password_verify()
> - Ligne 277 : password_hash()

> **Q: Quelles sont les différences par rapport à l'utilisation uniquement de md5 ?**
>
> R: MD5 n'est plus une norme de sécurité, on peut facilement faire le sens contraire et retrouver le mot de passe entré par l'utilisateur.
> L'utilisation de password_hash() permet de **hasher le mot de passe** de façon **irréversible** grâce à l'algorithme argon2 et ajoute automatiquement un salt qui rend le hash unique.
> Quant à `password_verify()`, elle hash le mot de passe et compare ce hash avec celui déjà enregistré.

> **Q: Pouvez-vous encore attaquer simplement le mot passe par force brute ?**
>
> R: Oui, cela est toujours possible mais **quasiment impossible**. Les attaques par force brute sont beaucoup plus difficiles et **coûteuses en temps et en ressources**. Grâce a l'alogrithme **Bcrypt** (qui est utiliser dans le password_hash('monMotDePasse', PASSWORD_DEFAULT)) les attaques par force brute sont extremement ralenti.

> **Q: Pouvez-vous encore utiliser une table arc-en-ciel ?**
>
> R: Non cela est impossible grâce à l'utilisation de Bcrypt qui ajoute un "sel unique" à chaque mot de passe avant de le hasher.

### 3 Aller plus loin avec HTTPS

> **Q: Mettez en place un micro site internet (un simple site qui dit "bonjour" suffira) avec un serveur apache2 ou nodejs (au choix).**
>
> R: 
> ```js
> import http from 'http';
> 
> const server = http.createServer((_, res) => {
>     res.statusCode = 200;
>     res.setHeader('Content-Type', 'text/plain');
>     res.end('Hello, world!\n');
> });
> 
> server.listen(3000, '127.0.0.1', () => {
>     console.log('Server running at http://127.0.0.1:3000/');
> });
> ```


> **Q: A quoi sert le protocole SSL ? Comment fonctionne t'il ?**
>
> R: Le protocole SSL (Secure Sockets Layer) a pour but de sécuriser les sites internet en chiffrant les données échangées entre le client et le serveur. 
> La norme utlisé aujourd'hui est TLS (Transport Layer Security), mais dire SSL reste le plus courant.
> Grâce au SSL, notre site passe de **HTTP** à **HTTPS**, ainsi les données échangées ne pourront pas être interceptées par un potentiel hacker qui utliserait *L'attaque par l'homme du milieu*. Pour fonctionner, SSL utilise un système de clé  :
> - **Une clé privée**, qui est gardée secrète par le serveur et utilisée pour déchiffrer les données.
> - **Une clé publique**, qui est accessible à tous et permet au client de chiffrer les informations envoyées au serveur.
> - **Une clé de session**, utilisée pour communiquer entre le client et le serveur une fois l'échange fait.
>
> **Comment fonctionne t-il ?**
> 1. Le client fait une demande de connexion au serveur sécurisé avec SSL, le serveur lui répond avec sa clé publique.
> 2. Le client utilise la clé publique du serveur pour chiffrer une clé de session et l'envoie.
> 3. Le serveur déchiffre cette clé de session avec sa clé privée.
> 4. Une fois cela fait, les deux parties utilisent la clé de session pour communiquer.


> **Q:Sécurisez votre site pour changer le protocole de HTTP à HTTPS**
>
> R: Voici le code JS permettant l'utilisation du HTTPS sur un serveur NodeJS en local
> ```js
> import https from 'https';
> import fs from 'fs';
> 
> const options = {
>   key: fs.readFileSync('./selfsigned.key'),
>   cert: fs.readFileSync('./selfsigned.crt')
> };
> 
> https.createServer(options, (_, res) => {
>   res.writeHead(200);
>   res.end('home page\n');
> }).listen(8080, () => {
>   console.log('Server is running at https://localhost:8080');
> });
> ```
> 
> Ici on utilise https et fs qui permettra de lire la clé et le certificat qui peuvent être généré grâce à cette commande openssl :
> ```bash
> sudo openssl req -x509 -nodes -days 365 -newkey rsa:4096 -keyout selfsigned.key -out selfsigned.crt
> ```
> Cependant, une erreur va s'afficher comme quoi le site est "Non sécurisé", c'est tout à fait normal, car le certificat est auto-signé, et les navigateurs actuels détectent ce problème, cependant, on peut bien constater que dans l'url on utilise https.


