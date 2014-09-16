## Demo d'un outils de "Todo list" en php et html5

![screenshot](./screenshot.png "scnsht")

Mise en œuvre du principe de base des websockets dans un prototype d'application de "todo lsit". Plusieurs clients partagent une même liste qui se met a jour de manière dynamique et peuvent rajouter des tâches.

### Principe de fonctionnement:

![diag](./diagramme-todo.png "diag")

### Websockets
- [ratchet](http://socketo.me/docs/hello-world) pour le serveur
- [html5](http://www.websocket.org/aboutwebsocket.html) pour le client

### Persistance
- Redis
- [predis](https://github.com/nrk/predis)

J'utilise une "liste", avec les deux opérations :
- `LRANGE` pour récupérer tout le contenu
- `RPUSH` pour rajouter des éléments

### Partie cliente
- le minuscule framework css : [min](http://minfwk.com/)
- jquery

### Ressources
- une clarification sur les [namespaces](https://jtreminio.com/2012/10/composer-namespaces-in-5-minutes/) en php 
