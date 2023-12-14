<?php
require_once(PROJECT_DB_CONEXION);

class Categoria {
    private int $id;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function crear(string $nombre): int {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL insertar_categoria(:nombre)");
        $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $pdo->beginTransaction();
        $statement->execute() ? $pdo->commit() : $pdo->rollBack();
        $affected_rows = $statement->rowCount();
        $statement = null;
        $pdo = null;
        return $affected_rows;
    }

    public static function listarTodas(): array {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL seleccionar_categorias()");
        $categorias = [];
        if ($statement->execute())
        {
            while ($row = $statement->fetch()) {
                array_push($categorias, new Categoria($row["id"], $row["nombre"]));
            }
        }
        $statement = null;
        $pdo = null;
        return $categorias;
    }

    public static function hayCategorias(): bool {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("SELECT COUNT(*) FROM categorias;");
        $presente = -1;
        if ($statement->execute())
            $presente = $statement->fetchColumn();
        $statement = null;
        $pdo = null;
        return $presente > 0;
    }

    public static function actualizar(int $id, string $nombre): int {
        $pdo = Conexion::conectar();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("CALL actualizar_categoria(:id, :nombre)");
        $statement->bindParam(":id", $id, PDO::PARAM_STR);
        $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $affected_rows = -1;
        $statement->execute() ? $pdo->commit() : $pdo->rollBack();
        $affected_rows = $statement->rowCount();
        $statement = null;
        $pdo = null;
        return $affected_rows;
    }

    public static function eliminar(int $id): int {
        $pdo = Conexion::conectar();
        $pdo->beginTransaction();

        $statement = $pdo->prepare("SELECT id FROM servicios WHERE idCategoria = '$id';");
        $servicios = [];
        if ($statement->execute()) {
            while ($row = $statement->fetch())
            {
                array_push($servicios, $row["id"]);
            }
        }

        foreach ($servicios as $id_servicio)
        {
            $statement = $pdo->prepare("DELETE FROM reservas WHERE idServicio = '$id_servicio';");
            $statement->execute();
        }

        foreach ($servicios as $id_servicio)
        {
            $statement = $pdo->prepare("DELETE FROM servicios WHERE id = '$id_servicio';");
            $statement->execute();
        }

        $statement = $pdo->prepare("CALL eliminar_categoria(:id)");
        $statement->bindParam("id", $id, PDO::PARAM_INT);
        $affected_rows = -1;
        $statement->execute() ? $pdo->commit() : $pdo->rollBack();
        $affected_rows = $statement->rowCount();
        $statement = null;
        $pdo = null;
        return $affected_rows;
    }

    public static function buscarPorId(int $id): Categoria {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("SELECT * FROM categorias WHERE id = '$id';");
        $categoria = null;
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                $categoria = new Categoria($row["id"], $row["nombre"]);
            }
        }
        $statement = null;
        $pdo = null;
        return $categoria;
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
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    protected function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

}

?>