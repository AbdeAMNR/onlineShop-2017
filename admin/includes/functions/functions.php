<?php
/**
 * Created by PhpStorm.
 * User: amnrLaptop
 * Date: 21-May-17
 * Time: 01:30
 */
function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        return $pageTitle;
    } else {
        return 'default';
    }
}

/**
 * @param $question
 * @return bool
 */
function isNullOrEmptyStr($question)
{
    return (!isset($question) || trim($question) === '');
}


/**
 * @param $query
 * @return bool
 */
function idExist($query)
{
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    }
    return false;
}

/**
 * @param $rqt
 * @return array
 */
function select($rqt)
{
    global $con;
    $stmt = $con->prepare($rqt);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * @param $rqt
 * @return string
 */
function selectCol($rqt)
{
    global $con;
    $stmt = $con->prepare($rqt);
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * @param $msg
 */
function noResult($msg)
{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="well-lg form-horizontal form-group-lg">
                    <h1>Oops!</h1>
                    <h2>Résultat</h2>
                    <div class="alert alert-danger" role="alert">
                        <strong>Désolé,</strong> <?= $msg; ?>
                    </div>
                    <div class="btn-group btn-group-lg">
                        <a href="index.php" class=" input-group  btn btn-primary">
                            <i class="glyphicon glyphicon-home iconfit"></i>Retour à la page d'accueil
                        </a>
                        <a href="#" class=" input-group  btn btn-default">
                            <i class="glyphicon glyphicon-envelope iconfit"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * @param $errArray
 * @param $url
 * @param $title
 */
function error($errArray, $url, $title)
{
    ?>
    <div class="container">
        <p></p>
        <fieldset>
            <legend><?= $title; ?></legend>
            <div class="form-group">
                <?php
                foreach ($errArray as $err) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Echec <i class="glyphicon glyphicon-thumbs-down"></i> <?= $err; ?>
                    </div>
                    <?php
                }
                ?>
                <a href="<?= $url; ?>" class="btn btn-primary">
                    <span class="fa fa-refresh"></span>
                    Essayez à nouveau
                </a>
            </div>
        </fieldset>
    </div>
    <?php
}

/**
 *
 */
function SuccessInsertion()
{
    ?>
    <div class="container">
        <p></p>
        <fieldset>
            <legend>Mise à jour</legend>
            <div class="form-group">
                <div class="alert alert-success" role="alert">
                    Succès <i class="glyphicon glyphicon-thumbs-up"></i>
                    La modification a été effectuée avec succès.
                </div>
            </div>
        </fieldset>
    </div>
    <?php
}

/**
 * @param $rqt
 * @param $array
 * @return int
 */
function update($rqt, $array)
{
    global $con;
    $stmt = $con->prepare($rqt);
    $stmt->execute($array);
    return $stmt->rowCount();
}


/**
 * @param $rqt
 * @return bool|mysqli_result
 */
function runQuery($rqt)
{
    global $connect;
    $resutSet = mysqli_query($connect, $rqt);
    return $resutSet;
}

/**
 * @param $productId
 * @return int
 */
function prodIdExist($productId)
{
    $myQuery = "SELECT * FROM produits WHERE prodId=$productId";
    global $connect;
    $rset = mysqli_query($connect, $myQuery);
    $rowCount = (int)mysqli_num_rows($rset);
    if ($rowCount == 1) {
        return true;
    } else {
        false;
    }
}

/**
 * @param $errors
 * @return string
 */
function display_errors($errors)
{
    $display = '<ul class="bg-danger">';
    foreach ($errors as $error) {
        $display .= '<li class="text-danger">' . $error . '</li>';
    }
    $display .= '</ul>';
    return $display;
}

/**
 * @param $dirty
 * @return string
 */
function desinfecter($dirty)
{
    $cln = filter_var($dirty, FILTER_SANITIZE_STRING);
    return htmlentities($cln, ENT_QUOTES, "UTF-8");
}

function money($number)
{
    return number_format($number, 2) . ' DH';
}


/**
 * @param $msg
 * @return string
 */
function headerMsg($msg)
{
    return '<div class="caption text-center"><h1 class="text-uppercase" style="color: red;">' . $msg . '</h1></div>';
}

function currentUrl()
{
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $params = $_SERVER['QUERY_STRING'];

    return $protocol . '://' . $host . $script . '?' . $params;
}
