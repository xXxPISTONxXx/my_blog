<?php
require('connect.php');
session_start();

function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

global $pdo;
//Check DB conn
function dbCheckError($query) {
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}
//SELECT require form one table
function selectAll($table, $params = []) {
    $sql = "SELECT * FROM $table";
    global $pdo;
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'".$value."'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }

    }
 
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//SELECT require for one row in one table
function selectOne($table, $params = []) {
    global $pdo;
    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'".$value."'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }

    //$sql = $sql . " LIMIT 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

//INSERT into DB
function insert($table, $params) {
    global $pdo;
    $i = 0;
    $coll = '';
    $mask = '';
    foreach ($params as $key => $value) {
        if ($i === 0) {
            $coll = $coll . "$key";
            $mask = $mask . "'" . "$value" . "'";
        } else {
            $coll = $coll . ", $key";
            $mask = $mask . ", '" . "$value" . "'";
        }
        $i++;
    }

    $sql = "INSERT INTO $table ($coll) VALUES ($mask)";

   /* tt($sql);
    exit();*/
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $pdo->lastInsertId();
}

//UPDATE row
function update($table, $id, $params) {
    global $pdo;
    $i = 0;
    $str = '';
    foreach ($params as $key => $value) {
        if ($i === 0) {
            $str = $str . $key . " = '" . $value . "'";
        } else {
            $str = $str . ", " . $key . " = '" . $value . "'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}
//DELETE row
function delete($table, $id) {
    global $pdo;

    $sql = "DELETE FROM $table WHERE id =". $id;
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

//Articles select with userid
function selectAllFromArticlesWithUsers($table1, $table2, $limit, $offset) {
    global $pdo;
    $sql = "
    SELECT  
    t1.id,
    t1.title,
    t1.img,
    t1.content,
    t1.status,
    t1.id_category,
    t1.pubdate,
    t2.username
    FROM $table1 AS t1 JOIN $table2 
    AS t2 ON t1.id_user = t2.id
    ORDER BY t1.pubdate DESC
    LIMIT $limit OFFSET $offset";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Articles select with userid on main
function selectAllFromArticlesWithUsersOnIndex($table1, $table2, $limit, $offset) {
    global $pdo;
    $sql = "SELECT a.*, u.username 
    FROM $table1 AS a JOIN $table2 AS u 
    ON a.id_user = u.id 
    WHERE a.status=1 
    ORDER BY a.pubdate DESC
    LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//Articles select with TOP on main
function selectTopCategoryFromArticlesOnIndex($table1) {
    global $pdo;
    $sql = "SELECT * FROM $table1 WHERE id_category = 9";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
//Search articles title/content
function searchInTitleAndContent($text, $table1, $table2) {
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = "SELECT a.*, u.username FROM $table1 AS a JOIN $table2 AS u ON a.id_user = u.id WHERE a.status=1
    AND a.title LIKE '%$text%' OR a.content LIKE '%$text%'";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
//Article select with userid on single
function selectArticleFromArticlesWithUsersOnSingle($table1, $table2, $id) {
    global $pdo;
    $sql = "SELECT a.*, u.username FROM $table1 
    AS a JOIN $table2 
    AS u ON a.id_user = u.id 
    WHERE a.id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}
//Article select for pagination
function countRow($table) {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM $table WHERE status = 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}

//SELECT count articles of one cat
function countRowCat($table, $id) {
    $sql =
        "SELECT COUNT(*) FROM $table 
        WHERE status = 1
        AND id_category=$id";
    global $pdo;

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();

}

//Articles select with userid on main
function selectAllFromArticlesWithUsersWithCat($table1, $table2, $id, $limit, $offset) {
    global $pdo;
    $sql = "SELECT a.*, u.username 
    FROM $table1 AS a 
    JOIN $table2 AS u 
    ON a.id_user = u.id 
    WHERE a.status=1 
    AND a.id_category=$id
    ORDER BY a.pubdate DESC
    LIMIT $limit OFFSET $offset";
    global $pdo;

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

//SELECT count of adm
function countRowAdm($table) {
    $sql = "SELECT COUNT(*) FROM $table";
    global $pdo;

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();

}
/*function selectAllFromArticlesWithUsersOnAdm($table1, $table2, $limit, $offset) {
    global $pdo;
    $sql = "SELECT a.*, u.username 
    FROM $table1 AS a JOIN $table2 AS u 
    ON a.id_user = u.id 
    WHERE a.status=1 
    ORDER BY a.pubdate DESC
    LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}*/

//SELECT require form one table
function selectAllforAdm($table, $limit, $offset) {
    $sql = "SELECT * FROM $table LIMIT $limit OFFSET $offset";
    global $pdo;

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}
