<div class="font4">Edit page</div><hr />
    <?php
        if(!empty($_GET['p']) && !empty($_GET['do']) && !empty($_GET['edit'])){
            if($_GET['edit'] == 'upload' || $_GET['edit'] == 'uploadhidden' || $_GET['edit'] == 'deleteimage' || $_GET['edit'] == 'deleteall'){
                if($_GET['edit'] == 'upload'){
                    include'pages/do/upload.php';
                }
                elseif($_GET['edit'] == 'uploadhidden'){
                    include'pages/do/uploadhidden.php';
                }
                elseif($_GET['edit'] == 'deleteimage'){
                    include'pages/do/deleteimage.php';
                }
                elseif($_GET['edit'] == 'deleteall'){
                    while($fetchimage = $imagequery->fetch(PDO::FETCH_ASSOC)){
                        unlink('../pages/img/' . $fetchimage['imagen']);
                    }
                    $handler->query('TRUNCATE images');
                    
                    echo'<div class="font4">All images have been deleted.</div>';
                    header("refresh:2;url=index.php?p=cms&do=edit");
                }
        }
        elseif($_GET['edit'] != 'upload' || $_GET['edit'] != 'deleteimage'){
            if($_GET['edit'] == 'gallery'){
    ?>
    <div class="boxer" style="width: 100%;">
        <div class="box-row">
            <div class="box_edit">Thumbnail</div>
            <!--<div class="box_edit">Edit description</div>-->
            <div class="box_edit">Delete</div>
    </div>
    <?php
        $i = 0;
    
        while($fetchimage = $imagequery->fetch(PDO::FETCH_ASSOC)){
            if($i % 2 == 0){
                $color = '#f3f3f3';
            }
            else{
                $color = '#ffffff';
            }
            
            echo"
                <div class='box-row' style='background: $color'>
                    <div class='box_edit'><img src='/pages/img/" . $fetchimage['imagen'] . "' style='width: 50%; height: 10%;' /></div>
                    <div class='box_edit'><a href='index.php?p=cms&do=edit&edit=editimage&edit=" . $fetchimage['id'] . "'>Delete</a></div>
                </div>
            ";
            
            $i++;
        }
    ?>
    </div>
    <?php    
            }
            elseif($_GET['edit'] == 'footer'){
                $getse  = $handler->query("SELECT * FROM settings");
                $fetch  = $getse->fetch(PDO::FETCH_ASSOC);
    ?>
                <form method="post">
                    <label for="footer">Footer content:</label><br />
                    <textarea name="footer" id="footer" rows="10" cols="80"><?php echo $fetch['footer']; ?></textarea><br />
                    <input type="submit" name="test" value="Submit" />
                    <script>
                        CKEDITOR.replace('footer', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]'});
                    </script>
                </form>
    <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $footer = ((!empty($_POST['footer']))? $_POST['footer'] : '');
                    
                    echo footer($handler, $footer);
                    
                    header('Location: index.php?p=cms&do=edit&edit=footer');
                }
            }
            else{
            $edit = $_GET['edit'];
            $editp  = $handler->query("SELECT * FROM pages WHERE ptitle = '$edit'");
            $fetchp = $editp->fetch(PDO::FETCH_ASSOC);
    ?>
    <form method="post">
        <label for="pname">Page name:</label><br />
        <input type="text" name="pname" value="<?php echo $fetchp['pname']; ?>" autocomplete="off" /><br />
        <label for="phidden">Hidden:</label><br />
        <input type="checkbox" name="phidden" <?php echo($fetchp['phidden'] == 'on' ? 'checked="checked"' : ''); ?> /><hr />
        <label for="pcontent">Header title:</label><br />
        <textarea name="htitle" id="htitle"><?php echo $fetchp['htitle']; ?></textarea><br />
        <label for="pcontent">Page content:</label><br />
        <textarea name="pcontent" id="pcontent"><?php echo $fetchp['pcontent']; ?></textarea>
        <input type="submit" value="Submit" />
        <script>
            CKEDITOR.replace('htitle', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]', height: '150px'});
        </script>
        <script>
            CKEDITOR.replace('pcontent', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]', "filebrowserImageUploadUrl": "/plugins/imgupload.php"});
        </script>
    </form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $pname      = $_POST['pname'];
            $titlef     = makeFriendlyFix($pname);
            $phidden    = ((empty($_POST['phidden']))? '' : $_POST['phidden']);
            $pcontent   = $_POST['pcontent'];
			$htitle     = $_POST['htitle'];
            $id         = $fetchp['id'];
            
            
            echo edit($handler, $id, $titlef, $pname, $phidden, $pcontent, $htitle);
    }
            }
        }
    }
    elseif(!empty($_GET['p']) && !empty($_GET['do']) && !empty($_GET['delete'])){
        $ename  = makeFriendlyFix($_GET['delete']);
        $delquery = "DELETE FROM pages WHERE ptitle = :ptitle";
        $querydo = $handler->prepare($delquery);
        
        try{
            $querydo->execute(array(
            ':ptitle'   => $ename
            ));
            echo'<div class="font4">Page deleted</div>';
            header("refresh:1;url=index.php?p=cms&do=edit");
        }
        catch(PDOException $e){
            echo'<div class="font4">Something went wrong, please try again.</div>';
        }
    }
    elseif(!empty($_GET['p']) && !empty($_GET['do']) && !empty($_GET['advanced'])){
        if($fetcht['advanced'] == 'true'){
            echo"<div class='font4'>Source code editor</div>";
            ?>
            <div id="demo" style="width: 75%;">            
                <form method="post">
                    <label for="pcontentadv">Source code editor:</label><br />
                    <textarea name="pcontentadv" id="pcontentadv">
                    </textarea>
                </form>
            </div>            
            <?php
        }
        else{
            echo"<div class='font4'>The advanced mode is disabled.</div>";
        }
    }
    else{
        if($getp->rowcount() == 0){
            echo'There are no pages in the database.';
        }
        else{
            ?>
            <div class="boxer">
                <div class="box-row">
                    <div class="box_edit">Page name:</div>
                    <div class="box_edit_small">Edit:</div>
                    <div class="box_edit_small">Posted by on Date and time:</div>
                    <div class="box_edit_small">Edited by on Date and time:</div>
                    <div class="box_edit_small">Delete:</div>
                </div>
            <?php
            
            $i = 0;
        while($fetchp = $getp->fetch(PDO::FETCH_ASSOC)){
            if($i % 2 == 0){
                $color = '#f3f3f3';
            }
            else{
                $color = '#ffffff';
            }
            echo"<div class='box-row' style='background: $color'>
                		<div class='box_edit'>
                            <a href='../index.php?p=" . $fetchp['ptitle'] . "'>" . $fetchp['pname'] . "</a>
                        </div>
      		            <div class='box_edit_small'>
                            <a href='index.php?p=cms&do=edit&edit=" . $fetchp['ptitle'] . "'>Edit</a>
                        </div>
      		            <div class='box_edit_small'>
                            " . $fetchp['puseridadd'] . " on " . $fetchp['postdate'] . "
                        </div>
      		            <div class='box_edit_small'>
                            " . $fetchp['puseridedit'] . " on " . $fetchp['editdate'] . "
                        </div>
      		            <div class='box_edit_small'>
                            <a href='index.php?p=cms&do=edit&delete=" . $fetchp['ptitle'] . "'>Delete</a>
                        </div>
                  </div>";
            $i++;
        }
            if($fetcht['gallery'] == 'true'){
                echo"<div class='box-row'>
                    <div class='box_edit'><a href='" . $website_url . "index.php?p=gallry'>" . $fetcht['galleryn'] . "</a></div>
                    <div class='box_edit_small'><a href='index.php?p=cms&do=edit&edit=upload'>Upload</a></div>
                    <div class='box_edit_small' ><div class='box_edit_small' style='width: 50%;'><a href='index.php?p=cms&do=edit&edit=deleteimage'>Delete image</a></div>
                    <div class='box_edit_small' style='width: 50%;'><a href='index.php?p=cms&do=edit&edit=deleteall'>Delete all images</a></div></div>
                </div>";    
            }
            echo"<div class='box-row'>
                    <div class='box_edit'>
                        Footer
                    </div>
                    <div class='box_edit_small'>
                        <a href='index.php?p=cms&do=edit&edit=footer'>Edit</a>
                    </div>
                 </div>        
                </div>";
        }
        }
?>