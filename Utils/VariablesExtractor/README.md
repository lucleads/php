# Variables Extractor

Clase que a partir de un string, obtiene un array con las *variables* contenidas en ese string.

Para diferenciar que se considera una variable, es necesario indicar en la constante "***VARIABLE_REGEXES***" los posibles indicadores de inicio y fin de una variable.

Es decir, si consideramos que para indicar que comienza una variable el string debe contener los carácteres "**INIT_VAR**", y la declaración de esta misma variable termina cuando exista "**;**" o "**END_VAR**", deberemos añadir a esta constante los siguientes valores:

`private const VARIABLE_REGEXES = [["INIT_VAR", [";", "END_VAR"]]]`

Si además, consideramos que hay varias formas de indicar una variable, como por ejemplo comenzar con "**EMPIEZA_VARIABLE**" y terminar con "**TERMINA_VARIABLE**" o "**;**", la constante quedaría de la siguiente forma:

`private const VARIABLE_REGEXES = [["INIT_VAR", [";", "END_VAR"]], ["EMPIEZA_VARIABLE", ["TERMINA_VARIABLE", ";"]]]`



### EJEMPLO DE USO

Esta clase puede ser útil para, por ejemplo, tratar con "templates". Librerías como **TWIG**, mediante el uso de plantillas permiten renderizar texto, pero no todas permiten determinar que variables contiene la plantilla.

De esta forma, indicando únicamente que determina el comienzo y fin de una declaración de variable podemos obtener una lista con todas las variables contenidas en el template.