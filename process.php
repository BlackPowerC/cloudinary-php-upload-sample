<?php
    require_once "vendor/autoload.php";

    \Cloudinary::config([
            "cloud_name" => 'xxx',
            "api_key" => 'xxxxx',
            "api_secret" => 'xxxxx'
    ]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Cloudinary image upload</title>
    <meta charset="utf-8"/>
    <link rel="icon" href="https://cloudinary-res.cloudinary.com/image/asset/favicon-192x192-d6a96e11dd5adfebbb717d154665ee80.png" type="image/png">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"/>
</head>

<body>
    <div class="container container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <?php
                if(isset($_FILES["image"]))
                {
                    ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Taille</th>
                            <th>Nom temporaire</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <?php echo $_FILES["image"]["name"] ?>
                            </td>
                            <td>
                                <?php echo $_FILES["image"]["size"] ?>
                            </td>
                            <td>
                                <?php echo $_FILES["image"]["tmp_name"] ?>
                            </td>
                            <td>
                                <?php echo $_FILES["image"]["type"] ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php
                    // Uploadding
                    try
                    {
                        $arr_result = \Cloudinary\Uploader::upload($_FILES["image"]["tmp_name"],
                            [
                                "folder"=>"opentrade/tests/",
                                "overwrite"=>true,
                                "public_id"=>md5(substr($_FILES["image"]["tmp_name"], strpos($_FILES["image"]["tmp_name"], "/tmp/")+1, strlen($_FILES["image"]["tmp_name"])))
                            ]);

                        echo '<table class="table table-striped"><tbody>' ;
                        foreach ($arr_result as $key =>$value)
                        {
                            ?>
                            <tr>
                                <td> <?php echo $key." "; print_r($value) ;?></td>
                            </tr>
                            <?php
                        }
                        echo '</tbody></table>' ;

                    }
                    catch (\Cloudinary\Error $r) {
                        echo $r->getMessage() ;
                    }
                }
                ?>
                    <a title="retour" class="btn btn-link" href="index.html">Cliquez pour recommencer</a>
                <?php
                ?>
            </div>
        </div>
    </div>
</body>

</html>
