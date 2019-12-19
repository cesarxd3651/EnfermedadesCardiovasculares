                <?php 

require_once "Conexion-view.php";

?>                
                                 <thead id="tblHead">
		           										   <tr>
		              										  <th>Nombres</th>
		                										<th>Apellidos</th>
		              										</tr>
		          								  </thead>

		         								   <?php
      												$result = $mysqli->query("SELECT  AdminNombre,AdminApellido,cu.CuentaCodigo from admin ad inner join cuenta cu on ad.CuentaCodigo=cu.CuentaCodigo where cu.CuentaPrivilegio=2 ");
     				 										while ($row = mysqli_fetch_array($result)) {

              												$datos=$row[0]."||".
                    										 $row[1]."||".
                    										 $row[2];
        														?>
         												   <tbody>
         						     				<tr style="cursor:pointer;" onclick="EnviarDatosDoctor('<?php echo $datos ?>');">
              											<td><?php echo $row["AdminNombre"]?></td>
                										<td><?php echo $row["AdminApellido"]?></td>
              										</tr>

	    												  <?php
	   														 }
	   														 ?>
            										</tbody>