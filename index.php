<?php

if(!isset($_POST['SubFile']))
{
    index();
}
else
{
     
    do_upload(); 
}    

function index()
{
    
    echo "<form method='post' action='index.php' enctype='multipart/form-data' />";
    echo '<input type="file" name="userfile" size="20" />';
    echo 'Introduce Password: <input type="password" name="pass" size="20" />';
    echo "<input type='submit' name='SubFile' value='Subir Fichero'>";    
    echo "</form>";
}

function do_upload()
{ 
        include( "classes/Upload.php" );
        $config['upload_path'] = './uploads/';
        // $config['allowed_types'] = '';
        $config['max_size']	= '100';
        $UpFile = new Upload($config);
        
        if ( ! $UpFile->do_upload())
        {      
                echo "<span style='color:#ff0000;'>Se ha producido un error</span>";
                index();
            
        }
        else
        {
                  
                                
                $dataFile = $UpFile->data();
                  
                $file = 'uploads/'.$dataFile['file_name'];
                $pass = $_POST['pass']; 
                //$output = system('./revtrans.php --password='.$pass.' '.$file);
                //printf("System Outputs: $output\n"); 
                exec('./revtrans.php --password='.$pass.' '.$file, $results); 
                 //parser mejorable pero bueno
                 $results = implode($results);
                 $results = str_replace('""','#',$results);
                 $results = str_replace(',','#',$results);
                 $results = str_replace('"','',$results);
                 $results = preg_split("/#/", $results);
                 
                $i = 0; 
                $aux = 0;
                $Keys = array();
                foreach($results as $result)
                {
                    
                    $Keys[$aux][] = $result; 
                    $i++;
                    if($i == 5)
                    {
                        $i = 0;
                        $aux ++;
                    }    
                }
                //print_r($Keys);
                $i = 0;
                foreach($Keys as $Key)
                {
                    if($i!=0)
                    {
                       echo $Key[0]."=>".$Key[2]."<br>"; 
                    }
                    $i++;
                }
                 
        }
}
 
?>
