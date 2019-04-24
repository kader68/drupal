# Récupérer les sources
git pull origin master

# Récupérer les librairies
composer install

# Mettre à jour la base de données Drupal
drush updb -y

#Ajout des config de pro
git add config/prod
git commit -m 'Mise à jour des config de prod'
git push origin master

# Importer les configurations
drush cim -y

#Vidage des caches
drush cr