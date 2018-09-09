<?php

"
E ai pessoal, vocês sabem o conceito de injeção de dependencias no PHP ?

Então continua lendo que eu vou te explicar.

Dependecy Injection é um padrão de design que permite a remoção de dependencias (módulos, plugin, classes) e torna possível altera-lás seja em tempo de execução (run-time) ou tempo de compilação (compile-time)

Esse citação faz o conceito parecer mais complicado do que ele é, no entanto isso não é verdade.

Injeção de Dependência providencia a um componente suas dependencias através do seu construtor, chamada de métodos ou inserindo em uma propriedade/atributo.

Nós demostramos o conceito de forma bem simples usando uma classe Database onde através do seu método construtor inserimos um DatabaseAdapter para que a classe Database possa usa-lá.

Vejam um ponto muito importante onde inserimos pelo método construtor da classe Database não uma classe concreta MysqlAdapter ou PostgresAdapter mas sim um interface, ou seja, uma abstração.

Em resumo nossa classe Database injeta uma interface DatabaseAdapter usando o seu método construtor. Isso nos permite baixo acoplamente, fácil manutenção deste código e facilidade na testabilidade desta classe Database uma vez que poderemos injetar suas dependencias de qualquer lugar que venhamos a usa-lá.


Referência: https://www.phptherightway.com/#dependency_injection

#housecursos #php7 #cursosonline #cursos #cursosdeti 
#cursosdev #dev #programacao #aprendaprogramar #sistemas #programador #tecnologia #cursosonlineti #code #coding #script #aprendendoaprogramar #hacker #escoladeprogramacao #cursosdeprogramacao #comoaprenderaprogramar
";

interface DatabaseAdapter {
	public function getTables();
}

class MysqlAdapter implements DatabaseAdapter {
	public function getTables() {
		return 'SHOW TABLES';
	}
}

class PostgresAdapter implements DatabaseAdapter {
	public function getTables() {
		return 'LIST TABLES';
	}	
}

class Database {
	private $adapter;

	function __construct(DatabaseAdapter $adapter) {
		$this->adapter = $adapter;
	}

}

$adapter = new PostgresAdapter();

$database = new Database($adapter);


