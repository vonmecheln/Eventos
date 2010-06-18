<?php
class Classe_Usuario extends Sistema_Persistencia {
	
	protected $_classe = "Classe_Usuario";
	protected $_tabela = "usuario";
	protected $_campos = array("usr_cod"=>array("Código","chave"),
								"usr_nome"=>array("Nome","texto",60,true),
								"usr_cpf"=>array("CPF","cpf",15,false),
							    "usr_rg"=>array("RG","rg",15,false),
								"usr_endereco"=>array("Endereço","texto",60,true),
								"usr_numero"=>array("Numero","inteiro",5,true),
								"usr_cep"=>array("CEP","cep",10,true),
								"usr_bairro"=>array("Bairro","texto",50,true),	
								"usr_telefone"=>array("Telefone","telefone",15,true),
								"usr_celular"=>array("Celular","telefone",15,false),
								"usr_email"=>array("E-mail","email","",true),
								"usr_login"=>array("Login","texto",60,true),
								"usr_senha"=>array("Senha","senha",60,true),
								"cid_cod"=>array("Cidade","cidade","",false),
								"grp_cod"=>array("Grupo","estrangeiro","",false),
								"stt_cod"=>array("Status","status","",false)
								);
	protected $_chavepk   = "usr_cod";
	protected $_descritor = "usr_nome";
	
	protected $_estrangeiros = array("grp_cod"=>"Classe_Grupo");
	protected $_formulario = array("trocarsenha"=>array("usr_senha"),
								"inscricao"=>array("usr_cod","usr_nome","usr_cpfg","cid_cod",
								"usr_endereco","usr_numero","usr_cep","usr_bairro","usr_telefone",
								"usr_celular","usr_email","usr_senha"));
	protected $_unicos = array("usr_login");
}
?>
