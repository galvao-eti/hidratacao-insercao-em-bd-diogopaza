<?php

	
	trait Conexao{
		
		public $atributos = [];
		public $classe;

		
		

		public function conectar(){

			 $conexao = new PDO('mysql:host=localhost;dbname=trabalho_pos_2017','root','');
			 //$conexao = new PDO('mysql:host=' . $localBanco . ';dbname=' .$baseDados . ',' . $usuario . ',' . $senha ) ;
 			 return $conexao;
		}

		public function pegarAtributos($objeto){
			$this->setaClasse();
			$this->atributos = get_object_vars($objeto);
			array_pop($this->atributos);
			array_pop($this->atributos);
			$this->percorrerArray();

			
		}

		public function gravarDados(){
			$atributosSql;

			$cont = 1;
			$contBindValue = 1;
			$sql = "INSERT INTO $this->classe (";
			$chaves = "";
			$conn = $this->conectar();
			$valoresSql = "";
			foreach ($this->atributos as $key => $value) {
				
				if(count($this->atributos) == $cont){
						$chaves = $chaves . $key . " )";
						$valoresSql = $valoresSql . "?";
				}else{

					$chaves = $chaves . $key . ',';
					$valoresSql = $valoresSql . "?,";
					$cont++;
				}
				 
			}

			$sql = $sql . $chaves . " VALUES( " . $valoresSql . " )";
			$stmt = $conn->prepare($sql);

			foreach ($this->atributos as $key => $value) {
				$stmt->bindValue($contBindValue, $value);
				$contBindValue++;
			}
						
			$stmt->execute();	

			echo "Gravado " . $this->classe . "<br>";


		}

		public function percorrerArray(){
			echo "<h4> Atributos da classe " . $this->classe . "</h4>";
			foreach ($this->atributos as $key => $value) {
				
					echo $key . " <br> ";
					
			}
		}

		public function setaClasse(){

			$this->classe = get_class($this);

			$this->classe = strtolower($this->classe);
			
			
		}

		

	}
		 

	class Usuario{

		use Conexao;
		public $email;
		public $senha;

	public function __construct($email, $senha){

		$this->email = $email;
		$this->senha = $senha;

	}



	}


	class Produto{

		use Conexao;
		public $nome;
		public $valor;
		//public $maisUm;


		public function __construct($nome, $valor){

		$this->nome = $nome;
		$this->valor = $valor;

	}

	}


	$user = new Usuario("testeFinal@terra","345");
	$user->conectar();
	$user->pegarAtributos($user);
	$user->gravarDados();
	
	$produto = new Produto("produtoFinalFinal",1100);
	$produto->conectar();
	$produto->pegarAtributos($produto);
	$produto->gravarDados();


	


?>