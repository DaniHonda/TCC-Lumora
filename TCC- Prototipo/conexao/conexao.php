<?php
class BancodeDados {
    private $host = "localhost";
    private $user = "root";
    private $senha = "prof@3t3c";
    private $banco = "gestao_merenda";
    public $con;

	public function conecta(){
        $this->con = mysqli_connect($this->host, $this->user, $this->senha, $this->banco);
        
        if(!$this->con){
			die ("Problemas com a conexão: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->con, "utf8mb4");
    }

	public function fechar(){
		if($this->con){
            mysqli_close($this->con);
        }
	}
}
?>