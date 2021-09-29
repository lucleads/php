# Estructura de "enumeraciones" en PHP

Estructura de clases para el tratamiento de objetos que contienen sus posibles valores.

Siguiendo esta estructura, podemos distribuir las responsabilidades de las clases de la siguiente forma:

- **Herencia de "Enum":** Contener los posibles valores de la clase

- **Herencia de "EnumExtension":** Value object que contendrá el valor

  - Este value object se encargará de validar la lógica propia de su atributo

- **Entidad:** Contiene los ValueObjects

  - Será la encargada de validar la lógica de negocio, haciendo uso de los métodos proporcionados por las enums

    

De esta forma, evitamos la duplicidad de código en métodos para validaciones y distribuimos de forma correcta las responsabilidades entre clases.

Hay que tener en cuenta que tanto las entidades indicadas, como los value objects y las herencias de enum pertenecen al "**DOMINIO**" del programa.

### CONTENIDO

Este paquete contiene las clases necesarias para generar la estructura de "enumeraciones" y un ejemplo de cómo implementarlas.

### EJEMPLO

En el caso de uso de ejemplo, tenemos un atributo "**type**" en la entidad "**TypeDefinition**" que puede contener los valores "***Tipo 1 / Tipo 2***". Estos valores están contenidos en la clase "**TypeEnum**" y el valor de este atributo en la entidad lo contiene el Value Object "**Type**".

La estructura de enums se encarga de validar que el atributo contenga un valor válido, y el value object valida la lógica propia del atributo.

La entidad mediante el método `checkConditions()` comprueba que se cumple la lógica de negocio necesaria, que en el ejemplo es:

----***Entendiendo que la entidad la componen 3 campos (type, strProperty, intProperty)***----

- En caso de que el tipo sea "**Tipo 1**", el campo "*strProperty*" no puede ser *null*
- En caso de que el tipo sea "**Tipo 2**", el campo "*intProperty*" no puede ser *null*

