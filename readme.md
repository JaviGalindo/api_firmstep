# Firmstep API

API to get and create QUEUE data

### Prerequisites
The connection to DB must be set in config/database.php file 

### How to use it

Create: 

url : yourURL/api/queue/create.php

body:[
type:Citizen,
firstName:javi,
lastName:test,
organization:Msi,
service:Benetifs
]

GET:

URL: yourURL/api/queue/get.php

Param(optional):type=XXXXX

## Authors

* **Javier Muñoz** - *javi.munoz.galindo@gmail.com*

