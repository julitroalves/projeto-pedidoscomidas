# projeto-pedidoscomidas

Projeto de Pedidos de Comidas escrito em PHP 7 para iniciantes desenvolvido pela HouseCursos.com

Link do Curso: https://www.housecursos.com/cursos/curso-completo-php7-padawan-ao-jedi/

Este projeto foi desenvolvido do zero utilizando PHP 7, composer, Phinx e algumas libs do mercado, tais como alguns components do Symfony Framework.

Para utilizar este projeto basta clonar este repositório e instalar os pacotes com composer, depois disso basta usar o phinx para instalar o banco de dados.

Este curso é voltado para estudantes e profissionais da área de TI.

```
composer install;

php ./vendor/bin/phinx migrate;
php ./vendor/bin/phinx seed:run;
```