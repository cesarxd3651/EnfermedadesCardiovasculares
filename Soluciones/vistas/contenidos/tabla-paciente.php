                <?php 

require_once "Conexion-view.php";

?>                
                                 <thead id="tblHead">
		           										   <tr>
		              										  <th>Nombres</th>
		                										<th>Apellidos</th>
		               												 <th >DNI</th>
		              										</tr>
		          								  </thead>

		         								   <?php
      												$result = $mysqli->query("SELECT  ClienteNombre,ClienteApellido,ClienteDNI,CuentaCodigo from cliente ");
     				 										while ($row = mysqli_fetch_array($result)) {

              												$datos=$row[0]."||".
                    										 $row[1]."||".
                    										 $row[2]."||".
                    										 $row[3];
        														?>
         												   <tbody>
         						     				<tr style="cursor:pointer;" onclick="EnviarDatos('<?php echo $datos ?>');">
              											<td><?php echo $row["ClienteNombre"]?></td>
                										<td><?php echo $row["ClienteApellido"]?></td>
               										 <td ><?php echo $row["ClienteDNI"]?></td>
              										</tr>

	    												  <?php
	   														 }
	   														 ?>
            										</tbody>