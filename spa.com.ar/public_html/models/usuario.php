<?php

require_once(PROJECT_DB_CONEXION);

class Usuario {

    private int $id;

    private int $id_tipo;

    private string $tipo;

    private string $email;

    private string $clave;

    public function __construct(int $id, int $id_tipo, string $tipo, string $email, string $clave)
    {
        $this->id = $id;
        $this->id_tipo = $id_tipo;
        $this->tipo = $tipo;
        $this->email = $email;
        $this->clave = $clave;
    }

    public static function registrar(int $id_tipo, string $email, string $clave): int {
        $pdo = Conexion::conectar();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("CALL insertar_usuario(:idCuenta, :email, :clave)");
        $statement->bindParam(":idCuenta", $id_tipo, PDO::PARAM_INT);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":clave", $clave, PDO::PARAM_STR);
        if ($statement->execute())
            $pdo->commit();
        else
            $pdo->rollBack();
        $affected_rows = $statement->rowCount();
        $statement = null;
        $pdo = null;
        return $affected_rows;
    }

    public static function logear(string $email, string $clave): Usuario {
        $pdo = Conexion::conectar();
        $sql = "CALL seleccionar_usuario(:email, :clave)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":clave", $clave, PDO::PARAM_STR);
        $usuario = null;
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                $usuario = new Usuario($row["id"], $row["idCuentaUsuario"], $row["tipo"], $row["email"], $row["clave"]);
            }
        }
        $statement = null;
        $pdo = null;
        return $usuario;
    }

    public static function listarTipos(): array {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL seleccionar_tipos_de_usuarios()");
        $results = [];
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                array_push($results, ["id" => $row["id"], "tipo" => $row["tipo"]]);
            }
        }
        $statement = null;
        $pdo = null;
        return $results;
    }

    public static function porDefecto(): int {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL tipo_usuario_por_defecto()");
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                $id = $row["id"];
            }
        }
        $statement = null;
        $pdo = null;
        return $id;
    }

    public function esAdmin(): bool {
        return strcasecmp($this->getTipo(), "Administrador") === 0;
    }

    public function esProfesional(): bool {
        return strcasecmp($this->getTipo(), "Profesional") === 0;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    protected function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id_tipo
     */
    public function getIdTipo(): int
    {
        return $this->id_tipo;
    }

    /**
     * Set the value of id_tipo
     */
    protected function setIdTipo(int $id_tipo): self
    {
        $this->id_tipo = $id_tipo;

        return $this;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    protected function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    protected function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of clave
     */
    public function getClave(): string
    {
        return $this->clave;
    }

    /**
     * Set the value of clave
     */
    protected function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }

}

?>