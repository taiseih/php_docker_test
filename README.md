# php_todo_docker
<h2>DockerでPHPの環境構築のテストを行なったものです</h2>
could not find driverが出たときはmysqlの接続を確認する
$ php -m | grep pdo　でpdoの確認をする、その時にmysqlがない場合は
RUN docker-php-ext-install pdo_mysqlを追記
