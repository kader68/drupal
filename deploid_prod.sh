# Récupérer les sources
git pull origin master

# Récupérer les librairies
composer install

# Mettre à jour la base de données Drupal
drush updb -y

# Export des configs de prod
drush csex prod -y

# Importer les configurations
drush cim -y

#Vidage des caches
drush cr
