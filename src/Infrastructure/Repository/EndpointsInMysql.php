<?php

namespace StatusChecker\Infrastructure\Repository;


use StatusChecker\Domain\Endpoint;
use StatusChecker\Domain\Endpoints;
use StatusChecker\Domain\EndpointStatus;
use StatusChecker\Exception\EntityNotFound;

/**
 * Class EndpointsInMysql
 * @package StatusChecker\Infrastructure\Repository
 */
class EndpointsInMysql implements Endpoints
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * UsersInMysql constructor.
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $password
     * @param string $port
     * @param string $charset
     */
    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password,
        string $port = '3306',
        string $charset = 'utf8'
    ) {
        $this->pdo = new \PDO(
            'mysql:host=' . $host . ';dbname=' . $name . ';port=' . $port . ';charset=' . $charset,
            $user,
            $password,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    /**
     * @param int $id
     * @return Endpoint
     */
    public function loadById(int $id): Endpoint
    {
        $statement = $this->pdo->prepare('SELECT * FROM `endpoint` WHERE `id` = ?');
        $statement->execute([intval($id)]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if (empty($row)) {
            throw EntityNotFound::fromEndpointId($id);
        }

        return new Endpoint($row['id'], $row['url'], new EndpointStatus($row['status']), $row['http_code']);
    }

    /**
     * @param EndpointStatus $status
     * @return Endpoint
     */
    public function loadByStatus(EndpointStatus $status): Endpoint
    {
        $statement = $this->pdo->prepare('SELECT * FROM `endpoint` WHERE `status` = ? LIMIT 0, 1');
        $statement->execute([$status->getValue()]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if (empty($row)) {
            throw EntityNotFound::fromEndpointStatus($status);
        }

        return new Endpoint($row['id'], $row['url'], new EndpointStatus($row['status']), $row['http_code']);
    }

    /**
     * @param Endpoint $endpoint
     */
    public function save(Endpoint $endpoint): void
    {
        $this->pdo->prepare('REPLACE INTO `endpoint`(`id`, `url`, `status`, `http_code`) VALUES(?, ?, ?, ?)')
            ->execute([
                $endpoint->getId(),
                $endpoint->getUrl(),
                $endpoint->getStatus(),
                $endpoint->getHttpCode()
            ]);
    }
}