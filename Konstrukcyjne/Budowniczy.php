<?php
interface SQLQueryBuilder
{
    public function Wybierz(string $table, array $fields): SQLQueryBuilder;

    public function Gdzie(string $field, string $value, string $operator = '='): SQLQueryBuilder;

    public function limit(int $start, int $offset): SQLQueryBuilder;

    public function getSQL(): string;
}


class MysqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass;
    }

   
    public function Wybierz(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = "WYBIERZ </br> " . implode(", ", $fields) . "</br> Z </br> " . $table;
        $this->query->type = 'Wybierz';

        return $this;
    }

    
    public function Gdzie(string $field, string $value, string $operator = '='): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['Wybierz', 'update', 'delete'])) {
            throw new \Exception("Gdzie można dodać tylko do WYBIERZ, ZAKTUALIZUJ lub USUŃ </br>");
        }
        $this->query->Gdzie[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['Wybierz'])) {
            throw new \Exception("LIMIT można dodać tylko do WYBIERZ");
        }
        $this->query->limit = "</br> LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->Gdzie)) {
            $sql .= " </br> GDZIE </br>" . implode(' ORAZ ', $query->Gdzie);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }
}

class PostgresQueryBuilder extends MysqlQueryBuilder
{
    
    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " PRZESUNIĘCIE " . $offset;

        return $this;
    }

    
}



function clientCode(SQLQueryBuilder $queryBuilder)
{
   

    $query = $queryBuilder
        ->Wybierz("uzytkowniki", ["imie", "email", "haslo"])
        ->Gdzie("wiek", 18, ">")
        ->Gdzie("wiek", 30, "<")
        ->limit(10, 20)
        ->getSQL();

    echo $query;

   
}



echo "Testowanie konstruktora zapytań MySQL : </br>";
clientCode(new MysqlQueryBuilder);

echo "</br></br>";

echo "Testowanie konstruktora zapytań PostgresSQL: </br>";
clientCode(new PostgresQueryBuilder);