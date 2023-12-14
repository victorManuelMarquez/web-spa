<?php

require_once(PROJECT_DB_CONEXION);
require_once(MODELO_CATEGORIA);

class Servicio {
    private int $id;

    private Categoria $categoria;

    private string $nombre;

    private ?string $media;

    private string $info;

    private float $tarifa;

    public function __construct(int $id, Categoria $categoria, string $nombre, ?string $media = null, string $info, float $tarifa)
    {
        $this->id = $id;
        $this->categoria = $categoria;
        $this->nombre = $nombre;
        $this->media = $media;
        $this->info = $info;
        $this->tarifa = $tarifa;
    }

    public static function crear(int $id_categoria, string $nombre, ?string $media = null, string $info, float $tarifa): int {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL insertar_servicio(:idCategoria, :nombre, :media, :info, :tarifa)");
        $statement->bindParam(":idCategoria", $id_categoria, PDO::PARAM_INT);
        $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $statement->bindParam(":media", $media, PDO::PARAM_STR);
        $statement->bindParam(":info", $info, PDO::PARAM_STR);
        $statement->bindParam(":tarifa", $tarifa, PDO::PARAM_STR);
        $affected_rows = $statement->execute() ? $statement->rowCount() : 0;
        $statement = null;
        $pdo = null;
        return $affected_rows;
    }

    public static function todosLosServicios(): array {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("CALL seleccionar_servicios()");
        $servicios = [];
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                array_push($servicios, new Servicio($row["id"], new Categoria($row["idCategoria"], $row["categoria"]), $row["nombre"], $row["media"], $row["info"], $row["tarifa"]));
            }
        }
        $statement = null;
        $pdo = null;
        return $servicios;
    }

    public static function buscarPorId(int $id): Servicio {
        $pdo = Conexion::conectar();
        $statement = $pdo->prepare("SELECT * FROM servicios WHERE id = '$id';");
        $servicio = null;
        if ($statement->execute())
        {
            while ($row = $statement->fetch())
            {
                $servicio = new Servicio($row["id"], Categoria::buscarPorId($row["idCategoria"]), $row["nombre"], $row["media"], $row["info"], $row["tarifa"]);
            }
        }
        $statement = null;
        $pdo = null;
        return $servicio;
    }

    public static function actualizar(int $id, int $id_categoria, string $nombre, ?string $media = null, string $info, string $tarifa): int {
        $pdo = Conexion::conectar();
        $pdo->beginTransaction();
        $statement = $pdo->prepare("CALL actualizar_servicio(:id, :idCategoria, :nombre, :media, :info, :tarifa)");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":idCategoria", $id_categoria, PDO::PARAM_INT);
        $statement->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $statement->bindParam(":media", $media, PDO::PARAM_STR);
        $statement->bindParam(":info", $info, PDO::PARAM_STR);
        $statement->bindParam(":tarifa", $tarifa, PDO::PARAM_STR);
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

        $statement = $pdo->prepare("DELETE FROM reservas WHERE idServicio = '$id';");
        $statement->execute();

        $statement = $pdo->prepare("CALL eliminar_servicio(:id)");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute() ? $pdo->commit() : $pdo->rollBack();
        $affected_rows = $statement->rowCount();
        $statement = null;
        $pdo = null;
        return $affected_rows;
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
     * Get the value of categoria
     */
    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     */
    protected function setCategoria(Categoria $categoria): self
    {
        $this->categoria = $categoria;

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

    /**
     * Get the value of media
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * Set the value of media
     */
    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get the value of info
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * Set the value of info
     */
    protected function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get the value of tarifa
     */
    public function getTarifa(): float
    {
        return $this->tarifa;
    }

    /**
     * Set the value of tarifa
     */
    protected function setTarifa(float $tarifa): self
    {
        $this->tarifa = $tarifa;

        return $this;
    }

}

?>