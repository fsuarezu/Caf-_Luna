
<?php if (isset($_GET['enviado'])): ?>
	<div style="background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;">
		<strong>¡Éxito!</strong> Su consulta ha sido enviada.
		<a href="Contactanos.php" style="float:right; text-decoration:none; color:#155724; font-weight:bold;">&times;</a>
	</div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
        Correo o contraseña incorrectos.
    </div>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'nombre'): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
        El nombre debe tener al menos 3 caracteres.
    </div>
<?php endif; ?>