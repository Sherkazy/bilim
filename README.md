AiO CMF
===

    composer install
    app/console doctrine:database:create --if-not-exists
    app/console doctrine:schema:update --dump-sql
    app/console doctrine:schema:update --force
    app/console sonata:media:fix-media-context
    app/console fos:user:create --super-admin admin admin@gmail.com adm1n || echo 'admin is exists'
    mkdir -p web/uploads
    setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs web/uploads
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/uploads
    app/console cache:clear
    app/console assets:install

