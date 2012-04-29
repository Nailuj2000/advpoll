<?php
/**
 * The core language file is in /languages/en.php and each plugin has its
 * language files in a languages directory. To change a string, copy the
 * mapping into this file.
 *
 * For example, to change the blog Tools menu item
 * from "Blog" to "Rantings", copy this pair:
 * 			'blog' => "Blog",
 * into the $mapping array so that it looks like:
 * 			'blog' => "Rantings",
 *
 * Follow this pattern for any other string you want to change. Make sure this
 * plugin is lower in the plugin list than any plugin that it is modifying.
 *
 * If you want to add languages other than English, name the file according to
 * the language's ISO 639-1 code: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */

$mapping = array(
	'votaciones:titulo' => 'Votaciones',
	'votaciones:menu' => 'Votaciones',
	'votaciones:nueva' => 'Nueva Votación',
	'votaciones:editare' => 'Editor de votaciones',
	'votaciones:enviada:nueva' => 'Votación creada satisfactoriamente',
	'votaciones:discusion:previa' => 'Dirección de enlace a la discusión previa a la votación',
	'votaciones:opciones' => 'Opciones de la votación: ',
	'votaciones:nueva:opcion' => '+',
	'votaciones:resultados' => 'Resultados de la votación',
	'votaciones:votar:opcion' => 'Elige la opción que prefieras',
	'votaciones:respuesta' => 'Opción',
	'votaciones:debate:previo:link' => 'Enlace al debate previo',
	'votaciones:advertencia:editar' => 'Por motivos de seguridad no se pueden modificar las opciones de una votación una vez creada',
	'votaciones:pregunta' => 'Título de la pregunta',
	'votaciones:advertencia:editar:titulo' => 'Por motivos de seguridad no se puede modificar la pregunta de la votación una vez creada',
	'votaciones:advertencia:editar:auditoria' => 'Por motivos de privacidad no se puede modificar esta opción una vez creada la votación',
	'votaciones:filtros:encurso' => 'En Curso',
	'votaciones:filtros:finalizadas' => 'Finalizadas',
	'votaciones:filtros:totus' => 'Todas',
	'votaciones:filtros:amigos' => 'De Amigos',
	'votaciones:filtros:trujaman' => 'Mías',
	'votaciones:filtros:noiniciadas' => 'No Iniciadas',
	'votaciones:opcion:borrame' => 'Bórrame',
	'votaciones:condorcet:leyenda:opcion' => 'Opción ',
	'votaciones:condorcet:leyenda' => 'Leyenda',
	'votaciones:condorcet:opciones:elegidas:usuario' => 'Estas son las opciones que eligió ',
	'votaciones:condorcet:resultado:final' => 'Resultados',
	'votaciones:condorcet:opciones:elegidas:papeleta' => 'Papeleta de voto en forma de matriz de ',
	'votaciones:condorcet:votar:opcion' => 'Ordena las opciones según tus preferencias y pulsa el botón "votar"',
	'votaciones:condorcet:auditoria:mostrar' => 'Mostrar auditoría',
	'votaciones:condorcet:pulsar:cambio' => 'Cambiar votación',
	'votaciones:anteriores:borradas:ok' => 'Se ha borrado tu elección anterior',
	'votaciones:pulsar:cambio' => 'Pulsa aquí para cambiar tu voto anterior',
	'votaciones:resultados:tarta:titulo' => 'Resultados de la votación',
	'votaciones:grupo' => 'Votaciones del grupo',	
	'votaciones:condorcet:info' => 'info',
	'votaciones:condorcet:ayuda:titulo' => '¿Cómo funciona una votación preferencial?',
	'votaciones:condorcet:ayuda:papeletas:seguramente' => 'Seguramente te estarás preguntando qué significa una tabla como ésta:',
	'votaciones:condorcet:ayuda:papeletas:notemas' => 
		'No temas, es bastante sencillo, básicamente esta tabla representa una papeleta de voto preferencial. El método inicial 
		que utilizaremos para representar los votos	es conocido como el método de <a href="http://es.wikipedia.org/wiki/M%C3%A9todo_de_Condorcet"> condorcet</a>
		 y es el método que explicaremos aquí.<br>',
	'votaciones:condorcet:ayuda:papeletas:explicacion:titulo' => 'Cómo se crea una papeleta de condorcet',
		
	'votaciones:condorcet:ayuda:papeletas:supongamos' => 'Supongamos que tenemos una lista de 4 opciones: <br/> A, B, C y D <br/>
		De las cuales queremos sacar a votación para ver qué preferencias tiene una comunidad con respecto a ellas. <br/>
		En una votación preferencial lo que importa es el orden en que coloques las opciones, ya que no estás votando
		por una sóla, sino por una lista ordenada según tus preferencias. <br/>
		Supongamos que el habitante <em>Face-Lance</em> prefiere los candidatos anteriores en el siguiente orden: <br><br>
		1. B <br/>
		2. A <br/>
		3. C <br/>
		4. D <br><br>
		En este caso la manera de hallar la matriz o tabla que representa su papeleta puede realizarse del siguiente modo: <br><br>
		1. Hacemos una tabla colocando las opciones A, B, C, y D tanto en las filas como en las columnas en el mismo orden en ambas.<br/>
		Nos quedará algo como lo siguiente:',
	'votaciones:condorcet:ayuda:papeletas:paso2' => '2. El siguiente paso consiste en ir comparando la opción de la fila con la opción de la columna,
		escribiendo un 1 en el caso en el que la fila gane a la columna en la elección de <em>Face-Lance</em> y escribiendo un 0 en el caso contrario.<br>
		Por ejemplo, en la votación que hizo <em>Face-Lance</em> la opción B gana a la opción A, por lo que escribiremos un 1 en la casilla correspondiente,
		con lo que nos quedará algo así:',
	'votaciones:condorcet:ayuda:papeletas:paso3' => '3. Lo que nos queda ahora es ir rellenando todas las casillas con el método anterior,
		con una anotación más:<br> En las casillas donde se enfrentan opciones iguales siempre se escribe un 0, por lo que es una condición indispensable
		que la diagonal principal sea una diagonal compuesta de ceros.<br>
		Por ejemplo en la casilla de la fila A columna A tendremos que escribir un 0. <br>
		Completando poco a poco la tabla nos irá quedando lo siguiente: <br>',
	'votaciones:condorcet:ayuda:papeletas:opciona' => ' La opción A pierde con B, y gana a C, y D. Su fila se completa así:',
	'votaciones:condorcet:ayuda:papeletas:opcionb' => ' La opción B gana a todas las demás. Su fila se completa así:',
	'votaciones:condorcet:ayuda:papeletas:opcionc' => ' La opción C pierde con A y con B, pero gana a D. Su fila se completará así:',
	'votaciones:condorcet:ayuda:papeletas:opciond' => ' La opción D pierde con todas las demás, por lo que su fila sólo contiene ceros:',
	'votaciones:condorcet:ayuda:papeletas:paso4' =>	'<br> 4. El siguiente paso es una cuestión de visibilización que nos servirá posteriormente para sacar conclusiones
		del método de condorcet. Consiste en colorear de verde aquellas casillas cuya puntuación sea mayor que la casilla simétrica con respecto a la diagonal.<br>
		<em>¿y eso qué significa?</em> En este paso inicial, simplemente significa que coloreemos de verde los 1 
		y de rojo los 0, salvo aquellos ceros que están en la diagonal. <br>
		Si nos fijamos, por ejemplo la casilla "Fila A, Columna B" tiene distinto color que la casilla simétrica "Fila B, Columna A".<br>
		Esto va a ser una regla de este tipo de tablas, y nos va a servir posteriormente para detectar si ha habido algún error en el proceso, pero
		también nos servirá para calcular el resultado final.',
	'votaciones:condorcet:ayuda:suma:explicacion:titulo' => 'Cómo se suman los votos en una votación de condorcet',
	'votaciones:condorcet:ayuda:suma:explicacion:maspapeletas' => 'Ahora que sabemos como se crean las papeletas, vamos a ver cómo operar con ellas,
		es decir, cómo podemos sumar los votos y sacar conclusiones. <br><br>
		Supongamos para ello que el héroe de nuestra fábula, encuentra un <em>bug</em> en el sistema que le permite crear tantas
		papeletas de votos como quisiera y que en lugar de reportar el error al lugar donde podrían solucionarlo, 
		su destino de héroe trágico se apodera de él y al igual que Aquiles despedazando troyanos, <em>Face-Lance</em>, rápido con el ratón,
		comienza a crear papeletas a diestro y siniestro.<br><br>
		Inicialmente crea sólo 4 papeletas distintas que se corresponden con las siguientes elecciones (se leen de izquierda a derecha):<br>
		A B C D <br>
		C D A B <br>
		C A B D <br>
		A B D C <br><br>
		Las tablas correspondientes a cada uno de estas elecciones serán las siguientes:',
	'votaciones:trujaman' => 'Votación creada por ',
	'votaciones:accion:voto:ok' => 'Tu voto se ha guardado correctamente',
	'votaciones:amigos' => 'Amigos',
	'votaciones:activas' => 'Activas',
	'votaciones' => 'Votaciones',
	
	'votaciones:vistazo:cerrada' => 'Finalizada: ',
	'votaciones:vistazo:auditoria' => ' Auditoría pública: ',
	'votaciones:vistazo:tipo' => ' Tipo: ',
	'votaciones:tipo:normal' => ' Normal',
	'votaciones:tipo:condorcet' => ' Preferencial',
	'votaciones:cerrada' => '¿Votación cerrada? (nadie podrá votar hasta que se active)',
	'votaciones:auditoria' => '¿Realizar auditoría pública? (los votos serán publicados detalladamente)',
	'votaciones:tipo' => 'Tipo de votación',
	'option:normal' => 'Normal: se vota una opción entre varias',
	'option:condorcet' => 'Preferencial: se vota el orden de todas las opciones',
	'votaciones:fecha:inicio' => 'La votación comienza el día ',
	'votaciones:fecha:fin' => ' y termina el día ',
	'votaciones:fecha:ayuda' => 'Dejar en blanco para controlar la votación de manera manual',
	'votaciones:acceso:ver' => '¿Quién puede ver los resultados de la votación?',
	'votaciones:acceso:votar' => '¿Quién puede votar?',
	'votaciones:vistazo:tiempo:desde' => ' Periodo de votación desde el ',
	'votaciones:vistazo:tiempo:hasta' => ' hasta el ',
	'votacion:vistazo:finalizada:si' => 'Finalizada',
	'votacion:vistazo:finalizada:no' => 'Activa',
	'votacion:vistazo:finalizada:menorfin:menorini' => 'No iniciada',
	'votacion:vistazo:finalizada:menorfin:mayorini' => 'Activa',
	'votacion:vistazo:finalizada:mayorfin:menorini' => 'Imposible',
	'votacion:vistazo:finalizada:mayorfin:mayorini' => 'Finalizada',
	'votaciones:grupos:habilitarvotaciones' => 'Activar las votaciones de grupo',
	'votaciones:accion:error:permisos' => 'Lo sentimos, no tienes permisos para votar',
	'votaciones:mostrar:resultados:durante' => '¿Mostrar resultados durante la votación (y auditoría si está activada)?',
	'votaciones:advertencia:editar:mostrar:resultados' => 'Por cuestiones de privacidad no se permite modificar este parámetro una vez creada la votación',
	'votaciones:vistazo:mostrar:resultados' => ' Resultados antes de finalizar:',
	'votaciones:mostrar:yes' => ' Sí',
	'votaciones:mostrar:no' => ' No',
	
	
		

);

add_translation('es', $mapping);
