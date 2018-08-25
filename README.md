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
cd /var/www/terresencouleurs/cert
openssl genrsa -des3 -out server.key 1024
openssl req -new -key server.key -out server.csr
cp server.key server.key.org
openssl rsa -in server.key.org -out server.key
openssl x509 -req -days 3650 -in server.csr -signkey server.key -out server.crt
```

```
sudo geany -i /etc/apache2/sites-available/terresencouleurs.conf
```
```
<VirtualHost *:80>
	ServerName terresencouleurs.net
	ServerAlias www.terresencouleurs.net
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
	SetEnv APP_SECRET cb583ef7145958fealk3c3fa492c028f
	SetEnv DATABASE_PATH "/home/al/Documents/data/terresencouleurs.sqlite"
</VirtualHost>
<virtualhost *:443>
	ServerName terresencouleurs.net
	ServerAlias www.terresencouleurs.net
  	DocumentRoot /var/www/terresencouleurs/public
    ErrorLog /var/log/apache2/terresencouleurs_error.log
    CustomLog /var/log/apache2/terresencouleurs_access.log combined
    SSLEngine On
    SSLOptions +FakeBasicAuth +ExportCertData +StrictRequire
    SSLCertificateFile "/var/www/terresencouleurs/certs/server.crt"
    SSLCertificateKeyFile "/var/www/terresencouleurs/certs/server.key"
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
    SetEnv APP_ENV=dev
	SetEnv APP_SECRET cb583ef7145958fealk3c3fa492c028f
	SetEnv DATABASE_PATH "/home/al/Documents/data/terresencouleurs.sqlite"
</virtualhost>
```
```
sudo a2ensite terresencouleurs.conf 
sudo service apache2 restart
```
```
sudo geany -i /etc/hosts
```
```
127.0.0.1	terresencouleurs.net www.terresencouleurs.net
```

Le site de dev est maintenant accessible sur 
https://terresencouleurs.net https://www.terresencouleurs.net

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
