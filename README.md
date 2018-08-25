terresencouleurs
=======
Créé le 25/08/2018 par Bernard Thomas

L'interface est responsive.

Utilise : 
- Symfony 4.1.3
- Bootstrap 4.1.3
- weblink gère le HTTP/2 et resource Hints pour charger les pages plus vite
- Twig comme moteur de template
- un écouteur TidyHtmlListener défini comme un service et branché sur onKernelResponse(). Cet écouteur permet de formater le html pour qu'il soit propre.
- Git et Github pour le versionning et le stockage du projet
- Composer pour gérer les dépendances du projet

Dépôt Git initialisé dans /var/www/terresencouleurs/.git/
https://github.com/ynofmys/terresencouleurs.git

gitignore géréré avec https://www.gitignore.io/api/symfony
```
sudo geany -i /etc/apache2/sites-available/terresencouleurs.conf
```
```
<VirtualHost *:80>
	ServerName terresencouleurs
	DocumentRoot /var/www/terresencouleurs/public
    <Directory /var/www/terresencouleurs/public>
        AllowOverride None
        Order Allow,Deny
        Allow from All
        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>
    <Directory /var/www/terresencouleurs/public/bundles>
        <IfModule mod_rewrite.c>
            RewriteEngine Off
        </IfModule>
    </Directory>
    ErrorLog /var/log/apache2/terresencouleurs_error.log
    CustomLog /var/log/apache2/terresencouleurs_access.log combined
    SetEnv APP_ENV=dev
	SetEnv APP_SECRET blablabla
	SetEnv DATABASE_PATH "/home/al/Documents/data/terresencouleurs.sqlite"
</VirtualHost>
```
```
sudo a2ensite terresencouleurs.conf 
sudo service apache2 restart
```
```
sudo geany -i /etc/hosts
```
```
127.0.0.1	terresencouleurs
```

Le site de dev est maintenant accessible sur 
http://terresencouleurs/

```
composer req twig
composer req weblink
```
```
cd /var/www/terresencouleurs/public
mkdir vendor
cd vendor
mkdir bootstrap
wget https://github.com/twbs/bootstrap/releases/download/v4.1.3/bootstrap-4.1.3-dist.zip
unzip bootstrap-4.1.3-dist.zip -d bootstrap
rm bootstrap-4.1.3-dist.zip
cd bootstrap
touch v.4.1.3
```
