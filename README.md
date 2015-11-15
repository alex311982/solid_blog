Solid blog
========

A Symfony project created on November 13, 2015, 4:40 pm.

Разворачивание проекта.
1. composer update - задать параметры к базе (pdo_mysql) в консольном режиме
2. создать базу - php app/console doctrine:database:create
3. создать таблицы - php app/console doctrine:schema:update --force
4. загрузить фикстуры - php app/console doctrine:fixtures:load
5. php app/console assets:install --symlink
6. php app/console cache:clear
7. sudo chmod 755 -R app/cache app/logs

