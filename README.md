bookworm
========

A Symfony project created on July 24, 2017, 6:22 pm.

API calls samples

| action | curl request |
| --- | --- |
| API&nbsp;root | curl --request GET \ --url http://localhost:8000/api |
| Authors&nbsp;GET | curl --request GET --url http://localhost:8000/api/author |
| Authors&nbsp;GET&nbsp;ONE | curl --request GET --url http://localhost:8000/api/author/2 |
| Authors&nbsp;CREATE | curl --request POST --url http://127.0.0.1:8000/api/author --data '{"firstName":"Linda","lastName":"Marshall","email":"lmaar@gmail.com"}' |
| Authors&nbsp;UPDATE | curl --request PUT --url http://127.0.0.1:8000/api/author/1 --data '{"firstName":"Joel","lastName":"Spolsky","email":"jspo@gmail.com"}' |
| Authors&nbsp;DELETE | curl --request DELETE --url http://127.0.0.1:8000/api/author/2 |
| Books&nbsp;GET | curl --request GET --url http://localhost:8000/api/book |
| Books&nbsp;GET&nbsp;ONE | curl --request GET --url http://localhost:8000/api/book/1 |
| Books&nbsp;CREATE | curl --request POST --url http://127.0.0.1:8000/api/book --data '{"title":"happy New 2017","isbn":"2-12-85-07","releaseDate":"2017-01-01"}' |
| Books&nbsp;UPSATE | curl --request PUT --url http://127.0.0.1:8000/api/book/1 --data '{"title":"Merry New 2015","isbn":"2-12-85-06","releaseDate":"2015-01-01"}' |
| Books&nbsp;DELETE | curl --request DELETE --url http://127.0.0.1:8000/api/book/2 |
